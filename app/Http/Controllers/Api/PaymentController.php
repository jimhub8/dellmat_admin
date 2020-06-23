<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Mobile\CartController;
use App\Mail\ThankYou;
use Illuminate\Http\Request;
use PayPal\Api\Payment;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\RedirectUrls;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Cart;
use App\Order;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderNotification;
use App\models\Product;
use App\models\Sale;
use App\models\AutoGenerate;
use App\models\Currency;
use App\models\Sale_update;
use App\models\Shippingaddress;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function shipping($address)
    {
        // dd($address);
        $shippingaddress = Shippingaddress::firstOrCreate(
            ['user_id' => auth('api')->id()],
            [
                'name' => (array_key_exists('name', $address)) ?$address['name'] : null,
                'street_address' => (array_key_exists('street_address', $address)) ?$address['street_address'] : null,
                'town' => (array_key_exists('town', $address)) ? $address['town'] : $address['county'] ,
                'country' => (array_key_exists('country', $address)) ?$address['country'] : null,
                'county' => (array_key_exists('county', $address)) ?$address['county'] : null,
                'postal_code' => (array_key_exists('postal_code', $address)) ?$address['postal_code'] : null,
                'phone' => (array_key_exists('phone', $address)) ?$address['phone'] : null,
                'email' => (array_key_exists('email', $address)) ?$address['email'] : null,
            ]
        );
        return $shippingaddress->id;
    }

    public function __construct()
    {
    }

    public function create(Request $request)
    {
        $usd = Currency::select('rate')->where('currency_code', 'USD')->first();
        $kes = Currency::select('rate')->where('currency_code', 'KES')->first();
        // dd($kes);
        $rate = $kes->rate / $usd->rate;
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                env('PAYPAL_ID'),     // ClientID
                env('PAYPAL_SECRETE')      // ClientSecret
            )
        );
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");
        // $item1 = new Item();
        // $item1->setName('Ground Coffee 40 oz')
        //     ->setCurrency('USD')
        //     ->setQuantity(1)
        //     ->setSku("123123") // Similar to `item_number` in Classic API
        //     ->setPrice(7.5);
        // $item2 = new Item();
        // $item2->setName('Granola bars')
        //     ->setCurrency('USD')
        //     ->setQuantity(5)
        //     ->setSku("321321") // Similar to `item_number` in Classic API
        //     ->setPrice(2);
        $items = [];
        $total = 0;
        $tax = 0;
        $shipment = 0;
        $qty = 0;
        $price = 0;
        foreach ($this->getCart() as $cart) {
            // dd($cart->name);
            $name = $cart->name['product_name'];
            // $total = $total + ($cart['item']['price'] * $cart['qty']);
            $item = new Item();
            // dd($cart['item']['price']);
            // dd($cart['qty']);
            $qty = $cart->name['order_qty'];
            $price = $cart->name['price'];
            $price = $price  * $rate;
            // $convert = new CurrencyConversion;
            // $price = $convert->convert($price);
            // dd($price);
            $items[] = $item->setName($name)
                ->setCurrency('USD')
                ->setQuantity($qty)
                ->setSku("123123") // Similar to `item_number` in Classic API
                ->setPrice($price);
        }
        $total = (int) $this->cart_total() * $rate;
        $tax = 0;
        // $tax = $total * 16 / 100;
        $shipment = 0;
        // $shipment = $total * 1 / 100;
        $subtotal = ($total - $tax - $shipment);
        // dd($tax, $shipment, $subtotal, $total);

        $itemList = new ItemList();
        $itemList->setItems($items);
        // $itemList->setItems(array($item1, $item2));
        $details = new Details();
        $details->setShipping($shipment)
            ->setTax($tax)
            ->setSubtotal($subtotal);
        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($total)
            ->setDetails($details);
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());
        // $baseUrl = getBaseUrl();
        // dd($details, $amount, $transaction);
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(env('APP_URL') . "/execute-payment")
            ->setCancelUrl(env('APP_URL') . "/paypal");
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));
        // $request = clone $payment;
        $payment->create($apiContext);
        // dd($apiContext);
        return redirect($payment->getApprovalLink());
        // return $payment;
    }

    public function execute(Request $request)
    {
        // After Step 1
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                env('PAYPAL_ID'),     // ClientID
                env('PAYPAL_SECRETE')      // ClientSecret
            )
        );

        $usd = Currency::select('rate')->where('currency_code', 'USD')->first();
        $kes = Currency::select('rate')->where('currency_code', 'KES')->first();
        $rate = $kes->rate / $usd->rate;
        $total = (int) $this->cart_total() * $rate;
        $tax = 0;
        $shipment = 0;
        $subtotal = ($total - $tax - $shipment);
        // $tax = $total * 16 / 100;
        // $shipment = $total * 1 / 100;
        $subtotal = $total - $tax - $shipment;

        $paymentId = $request->paymentId;
        // dd($paymentId);
        $payment = Payment::get($paymentId, $apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->PayerID);
        $transaction = new Transaction();
        $amount = new Amount();
        $details = new Details();

        $details->setShipping($shipment)
            ->setTax($tax)
            ->setSubtotal($subtotal);

        $amount->setCurrency('USD');
        $amount->setTotal($total + $tax + $shipment);
        $amount->setDetails($details);
        $transaction->setAmount($amount);
        $execution->addTransaction($transaction);
        $result = $payment->execute($execution, $apiContext);
        // dd($total);

        $this->paypal_payment($payment);


        // $order = new Order;
        // $order->buyer_id = auth('api')->id();
        // // $order->buyer_id = auth('api')->id();
        // $order->payment_id = $payment->id;

        // // foreach ($cart as $product) {
        // //     $order->company_id = $product['item']['company_id'];
        // // }
        // $order->address = 'Nairobi';
        // $order->status = 'Payed';
        // $order->amount = $amount->total;
        // $order->name = auth('api')->user()->name;
        // $order->cart = serialize($this->getCart());
        // $order->paypal = serialize($payment);
        // // $orderSave = auth('api')->user()->orders()->save();
        // $order->save();
        // $cart = $this->getCart();
        // // $this->getCartProduct();
        // $user = auth('api')->user();
        // // $this->sales('Payed', 'test');

        // $sale_update = new Sale_update();
        // $sale_update->sold('Paid', $order->id);
        // Notification::send($user, new OrderNotification($order, $cart));
        // if ($order->save()) {
        //     $request->session()->forget('cart');
        // }
        return redirect('/#/thankyou');
        // Create Orders

        // return $order;
        // return $payment;
        // return $request('paymentId');
    }


    public function paypal_payment($payment)
    {
        // return $request->all();
        // dd($this->getCart());
        $cart_same = new SaleController;
        $cart = $this->getCart();
        // return $cart;

        $res = $cart_same->sale($cart, 'Paypal', $payment, null);
        return $res;
    }


    public function cash_delivery(Request $request)
    {
        // return $request->all();
        // dd($this->getCart());
        $cart_same = new SaleController;
        $cart = $this->getCart();
        // return $cart;
        $res = $cart_same->sale($cart, 'Cash on delivery', null, $request->shipping);
        return $res;
    }
    public function sales($status, $account)
    {
        // dd($account['payment']);
        $cart = $this->getCart();
        // dd($cart);
        if ($status == 'Unconfirmed') {
            foreach ($cart as $product) {
                $sales = new Sale;
                $sales->product_id = $product->id;
                $sales->user_id = auth('api')->id();
                $sales->company_id = $product->company_id;
                $sales->list_price = $product->list_price;
                $sales->price = $product->price;
                $sales->quantity = $product->qty;
                $sales->total = $product->price;
                $sales->status = $status;
                $sales->client_name = $account['name'];
                $sales->client_email = $account['email'];
                $sales->client_phone = $account['phone'];
                $sales->client_address = $account['address'];
                $sales->client_city = $account['city'];
                $sales->client_country = $account['country'];
                $sales->payment = $account['payment'];
                $sales->product_name = $product->product_name;
                $sales->cart = serialize(Product::find($product->id));
                $sales->save();
            }
        } else {
            foreach ($cart as $product) {
                $user = auth('api')->user();
                $sales = new Sale;
                $sales->product_id = $product->id;
                $sales->user_id = auth('api')->id();
                $sales->company_id = $product->company_id;
                $sales->list_price = $product->list_price;
                $sales->price = $product->price;
                $sales->quantity = $product->qty;
                $sales->total = $product->price;
                $sales->status = $status;
                $sales->client_name = $user->name;
                $sales->client_email = $user->email;
                $sales->client_phone = $user->phone;
                $sales->client_address = $user->address;
                $sales->product_name = $product->product_name;
                $sales->cart = serialize(Product::find($product->id));
                $sales->save();
            }
        }
        return $sales;
    }

    public function getCart()
    {
        $cart = new CartController;
        return $cart->getCart(auth('api')->id());
    }
    public function returngetCart()
    {
        // dd(Session::get('cart'));
        if (Session::has('cart')) {
            $carts = Session::get('cart');
            $cartA = [];
            foreach ($carts->items as $itemsC) {
                $cartA[] = $itemsC;
            }
            return ($cartA);
            $oldCart = Session::has('cart') ? Session::get('cart') : null;
            $cart = new Cart($oldCart);
            return $cart->getCart();
        } else {
            return;
        }

        // Get Total if coupons

    }

    public function getCartProduct()
    {
        $cart = $this->getCart();
        foreach ($cart as $product) {
            $cart_id = $product->id;
            $cart_qty = $product->qty;
            $product_s = Product::find($cart_id);
            $new_qty = $product_s->quantity - $cart_qty;
            // dd($product_s->quantity .' - '. $cart_qty . ' = '. $new_qty);
            $product = Product::where('id', $cart_id)->update(['quantity' => $new_qty]);
        }
        return $product;
    }


    public function cart_total()
    {
        return \Cart::getTotal();

        return str_replace(',', '', $cart);
    }

}

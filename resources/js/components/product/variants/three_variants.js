export function summary_3(itemAttribute_arr, variants, attribute_arr, product, sku_details, unique_sku) {
    // variants = variants
    // itemAttribute_arr = itemAttribute_arr
    // var attribute_arr = attribute_arr
    var i = 0
    for (let index = 0; index < attribute_arr.length; index++) {
        const element = attribute_arr[index];
        // console.log(element);
        for (let index_1 = 1; index_1 < attribute_arr.length; index_1++) {
            const element_1 = attribute_arr[index_1];
            for (let index_2 = 2; index_2 < attribute_arr.length; index_2++) {
                const element_2 = attribute_arr[index_2];
                // console.log(element_1);
                for (let key = 0; key < element.tags.length; key++) {
                    const element_a = element.tags[key];
                    // console.log(element_a);
                    for (let key_1 = 0; key_1 < element_1.tags.length; key_1++) {
                        const element_b = element_1.tags[key_1];
                        for (let key_2 = 0; key_2 < element_2.tags.length; key_2++) {
                            const element_c = element_2.tags[key_2];
                            if (element_a.option_name != element_b.option_name && element_a.option_name != '' && element_b.option_name != '' && element != element_1 && element_a.option_name != element_c.option_name && element_a.option_name != '' && element_c.option_name != '' && element != element_2 &&
                                element_b.option_name != element_c.option_name && element_b.option_name != '' && element_c.option_name != '' && element_1 != element_2) {
                                i++

                                // console.log(element_a.option_name + element_b.option_name);
                                var sku_no = product.product_name.substring(0, 2) + '_' + element_b.option_name.substring(0, 2) + '_' + element_a.option_name.substring(0, 2) + '_' + element_c.option_name.substring(0, 2)
                                // var sku_no = null
                                // console.log(sku_no);
                                if (sku_details.length > 0) {
                                    var sku_no = sku_no + ("_00000000" + ((unique_sku) + i)).slice(-8)
                                    sku_details.forEach(element_sku => {
                                        console.log(sku_no, '               ', element_sku.sku_no);
                                        if (sku_no == element_sku.sku_no) {
                                            itemAttribute_arr.push({
                                                item_name: product.product_name + '-' + element_b.option_name + '/' + element_a.option_name + '/' + element_c.option_name,
                                                sku_no: sku_no,
                                                price: element_sku.price,
                                                reorder_point: element_sku.reorder_point,
                                                qty_available: element_sku.quantity,
                                            })

                                            sku_no = ''
                                        }

                                    });
                                } else {
                                    sku_no = sku_no + ("_00000000" + ((unique_sku) + i)).slice(-8)
                                    itemAttribute_arr.push({
                                        item_name: product.product_name + '-' + element_b.option_name + '/' + element_a.option_name + '/' + element_c.option_name,
                                        sku_no: sku_no,
                                        price: 0,
                                        reorder_point: 0,
                                        qty_available: 0,
                                    })
                                    sku_no = ''

                                }

                            }
                        }
                    }
                }
            }
        }
    }
}

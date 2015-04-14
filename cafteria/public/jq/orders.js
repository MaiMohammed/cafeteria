$(function() {


    var order = "yes";

function getProduct(date,user_id){
    $.ajax({
        url: "orders",
        type: "POST",
        dataType: "json",
        data: {date: date,user_id:user_id},
        //async: true,
        //cache: false,
        //timeout:50000,
        success: function(m) {
            //table = '<table border="1" id="first"><tr><td>order date</td><td>user name</td><td>room no</td><td>action</td></tr>';
            n=m;
        },
        error: function() {
            alert("Errorr");
        }
    });
        return n;
}
    function getOrders() {
        $.ajax({
            url: "orders",
            type: "POST",
            dataType: "json",
            data: {data: order},
            //async: true,
            //cache: false,
            //timeout:50000,
            success: function(r) {
                //table = '<table border="1" id="first"><tr><td>order date</td><td>user name</td><td>room no</td><td>action</td></tr>';
                $("#view-content").empty();
                $(r).each(function(i) {
                    table = '<table border="1" id="first">\n\
                                <tr>\n\
                                    <td>order date</td>\n\
                                    <td>user id</td>\n\
                                    <td>user name</td>\n\
                                    <td>room no</td>\n\
                                    <td>action</td>\n\
                                </tr>\n\
                                <tr>\n\
                                    <td>' + r[i].order_date + '</td>\n\
                                    <td>' + r[i].user_id + '</td>\n\
                                    <td>' + r[i].user_name + '</td>\n\
                                    <td>' + r[i].room_no + '</td>\n\
                                    <td>deliver</td>\n\
                                </tr>\n\
                            </table>';
                    $("#view-content").append(table);
                    //$("#view-content").append(r[i].order_date);
                    date=r[i].order_date;
                    user_id=r[i].user_id;
//                    product = getProduct(date,user_id);
//                    
//                    $(product).each(function(i) {
//                        table2 = '<table border="1" id="first">\n\
//                                    <tr>\n\
//                                        <td>order date</td>\n\
//                                        <td>user id</td>\n\
//                                        <td>user name</td>\n\
//                                        <td>room no</td>\n\
//                                        <td>action</td>\n\
//                                    </tr>\n\
//                                    <tr>\n\
//                                        <td>' + product[i].prod_name + '</td>\n\
//                                        <td>' + product[i].prod_image + '</td>\n\
//                                        <td>' + product[i].prod_price + '</td>\n\
//                                        <td>' + product[i].product_quantity + '</td>\n\
//                                        <td>deliver</td>\n\
//                                    </tr>\n\
//                                </table>';
//                        $("#view-content").append(table2);
//
//                    });
                });
                
                

            },
            error: function() {
                alert("Error");
            }
        });
    }
    setInterval(getOrders, 1000);
    //getOrders();

})


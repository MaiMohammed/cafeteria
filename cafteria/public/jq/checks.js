/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    
    
    
    var startDate;
    var endDate;
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yy = today.getFullYear();
    if (dd < 10) {
        dd = '0' + dd
    }
    if (mm < 10) {
        mm = '0' + mm
    }
    //var today_data = yyyy + '-' + mm + '-' +dd ; 
    var today_data = yy + '-' + mm + '-' + dd;
    //$('#startDate').val(today_data);
    $('#startDate').val("Date from");
    $('#startDate').datepicker({dateFormat: 'yy-mm-dd 00:00:00'});
    $('#endDate').val("Date to");
    $('#endDate').datepicker({dateFormat: 'yy-mm-dd 00:00:00'});
    
    function checksOfUsers(startDate,endDate,user_id){
        $.ajax({
                    url: "checks" ,
                   // cashe:false,
                    type:"POST",
                    dataType:"json",
                    data:{startDate:startDate,endDate:endDate,user_id:user_id},
                    success: function(r) {
                        //$("#view-content").append(r);
                        table='<table border="1" id="first"><tr><td>user name</td><td>total price</td></tr>';
                        for(var i=0;i<r.length;i++){
                             table+='<tr><td class="name" id="'+r[i].id+'">'+r[i].user_name+'</td><td>'+r[i].total_price+'</td></tr>';
                        }
                        table +="</table>";
                        //$("#datetotal").empty();
                        $("#first").remove();
                        $("#second").remove();
                        $("#third").remove();
                        $("#datetotal").append(table);

                    },
                    error:function(){
                        alert("Error");
                    }
                });
    }
    
    if(($("#startDate").val() !== "Date from" || $("#startDate").val() !== "") && ($("#endDate").val() !== "Date to" || $("#endDate").val() !== "")){
        
        
        
        $("#user_id").change(function(){
            
            startDate=$("#startDate").val();
            endDate=$("#endDate").val();
            user_id=$(this).val();
            checksOfUsers(startDate,endDate,user_id);
            //console.log("select"+startDate+"end"+endDate+"user"+user_id);
            
            
            
        });
        
        $("#endDate").change(function(){

            startDate=$("#startDate").val();
            endDate=$(this).val();
            console.log("date"+startDate);
            if($("#user_id").val() !== ""){
                
                user_id=$("#user_id").val();
                
                checksOfUsers(startDate,endDate,user_id);
            }else{
                $.ajax({
                    url: "checks" ,
                   // cashe:false,
                    type:"POST",
                    dataType:"json",
                    data:{startDate:startDate,endDate:endDate},
                    success: function(r) {
                        //$("#view-content").append(r);
                        table='<table border="1" id="first"><tr><td>user name</td><td>total price</td></tr>';
                        for(var i=0;i<r.length;i++){
                             table+='<tr><td class="name" id="'+r[i].id+'">'+r[i].user_name+'</td><td>'+r[i].total_price+'</td></tr>';
                        }
                        table +="</table>";
                        //$("#datetotal").empty();
                        $("#first").remove();
                        $("#second").remove();
                        $("#third").remove();
                        $("#datetotal").append(table);

                    },
                    error:function(){
                        alert("Error");
                    }
                });
            }

            
        });

        $(document).delegate(".name","click",function(){
            var userID=$(this).attr("id");
            startDate=$("#startDate").val();
            endDate=$("#endDate").val();
            console.log(userID);
            $.ajax({
                url: "checks" ,
               // cashe:false,
                type:"POST",
                dataType:"json",
                data:{userId:userID,startDate:startDate,endDate:endDate},
                success: function(r) {
                    //$("#view-content").append(r);
                    table='<table border="1" id="second"><tr><td>order_date</td><td>total price</td></tr>';
                    for(var i=0;i<r.length;i++){
                         table+='<tr><td class="date" id="'+r[i].user_id+'">'+r[i].order_date+'</td><td>'+r[i].total_price+'</td></tr>';
                    }
                    table +='</table>';
                    //$("#datetotal").empty();
                    $("#second").remove();
                    $("#third").remove();
                    $("#datetotal").append(table);

                },
                error:function(){
                    alert("Error");
                }
            });
        });
        $(document).delegate(".date","click",function(){

            var date=$(this).text();
            var user_id=$(this).attr("id");
            //console.log(tdText);
            $.ajax({
                url: "checks" ,
               // cashe:false,
                type:"POST",
                dataType:"json",
                data:{user_id:user_id,date:date},
                success: function(r) {
                    //$("#view-content").append(r);
                    table='<table border="1" id="third"><tr><td>product</td><td>image</td><td>quantity</td><td>price</td></tr>';
                    for(var i=0;i<r.length;i++){
                         table+='<tr><td>'+r[i].prod_name+'</td><td>'+r[i].prod_image+'</td><td>'+r[i].product_quantity+'</td><td>'+r[i].total_price+'</td></tr>';
                    }
                    table +='</table>';
                    //$("#datetotal").empty();
                    $("#third").remove();
                    $("#datetotal").append(table);

                },
                error:function(){
                    alert("Error");
                }
            });
        });
    }
    //$("#datetotal").remove();
})




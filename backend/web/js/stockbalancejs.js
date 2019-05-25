var orderList = [];
$(document).on('ready pjax:success', function() {
  //alert();

      $(".btn-trasfer").attr("disabled","disabled");
        $(".table-grid input").iCheck({
              checkboxClass: "icheckbox_square-red",
              radioClass: "iradio_square-red",
              increaseArea: "20%" // optional
         });
        $(".iCheck-helper").click(function(){

                  $(this).parent().each(function(i1, e1){
                      if($(e1).children().attr("name") == "selection[]"){
                          if($(e1).children().prop("checked")){
                              // console.log($(e1).children().val());
                              $(e1).children().prop("checked", true);

                              // $(".all-print").show();
                          }else{

                              // console.log("un check"+$(e1).children().val());
                              $(e1).children().prop("checked", false);
                              $(document).find("input[name='selection_all']").prop("checked", false);
                              $(document).find("input[name='selection_all']").parent().removeClass("checked");
                          }
                          orderList = [];
                          $(".icheckbox_square-green input[name='selection[]']:checked").each(function(i,e){
                              orderList.push(e.value);
                          });
                           //console.log(orderList);
                          orderStatusList = [];
                          $(".icheckbox_square-green input[name='selection[]']:checked").each(function(i,e){
                              orderStatusList.push($(e).parents("tr").attr("data-status"));
                          });
                          // console.log(orderStatusList);
                      }else{
                          orderList = [];
                          if($(e1).children().prop("checked")){
                               console.log("check all");
                              $(".icheckbox_square-green input[name='selection[]']").each(function(i,e){
                                   console.log(e.value);
                                  $(e).prop("checked", true);
                                  $(e).parent().addClass("checked");
                                  orderList.push(e.value);
                              });
                          }else{
                              // console.log("un check all");
                              $(".icheckbox_square-green input[name='selection[]']").each(function(i,e){
                                  // console.log(e.value);
                                  $(e).prop("checked", false);
                                  $(e).parent().removeClass("checked");
                                  orderList = [];
                              });
                          }

                           console.log(orderList);
                      }
                      // console.log(orderList);
                    //  alert(orderList[0]);
                      if(orderList.length > 0){
                        $(".btn-trasfer").attr("disabled",false);
                        $(".btn-trasfer").removeClass("btn-default");
                        $(".btn-trasfer").addClass("btn-primary");
                        $(".remove_item").html("["+orderList.length+"]");
                          $(".btn-bulk-remove").attr('disabled',false);
                          $(".btn-printbarcode").attr('disabled',false);
                          $(".btn-print-stock").attr('disabled',false);
                          $(".btn-add-component").attr('disabled',false);
                          $(".btn-view").attr('disabled',false);
                        $(".btn-update").attr('disabled',false);
                        $(".listid").val(orderList);
                        $("#items").html("สินค้าจำนวน "+orderList.length+" รายการ");
                         $(".btn-bulk-remove").removeClass("btn-default");
                        $(".btn-bulk-remove").addClass("btn-danger");
                       // console.log("niran");
                      }else{
                        $(".btn-trasfer").attr("disabled",true);
                        $(".btn-trasfer").removeClass("btn-primary");
                        $(".btn-trasfer").addClass("btn-default");
                        $(".remove_item").html("["+orderList.length+"]");
                        $(".btn-bulk-remove").attr('disabled',true);
                        $(".btn-printbarcode").attr('disabled',true);
                          $(".btn-print-stock").attr('disabled',true);
                          $(".btn-add-component").attr('disabled',true);
                        $(".btn-view").attr('disabled',true);
                        $(".btn-update").attr('disabled',true);
                        $(".listid").val(orderList);
                         $("#items").html("สินค้าจำนวน "+orderList.length+" รายการ");
                        //console.log("ddfdfdfd");
                      }
                  });
              });

});
    $(".table-grid input").iCheck({
          checkboxClass: "icheckbox_square-red",
          radioClass: "iradio_square-red",
          increaseArea: "20%" // optional
    });
$(".group-role input").iCheck({
    checkboxClass: "icheckbox_square-red",
    radioClass: "iradio_square-red",
    increaseArea: "20%" // optional
});
    
   $(".iCheck-helper").click(function(){

                  $(this).parent().each(function(i1, e1){
                      if($(e1).children().attr("name") == "selection[]"){
                          if($(e1).children().prop("checked")){
                              // console.log($(e1).children().val());
                              $(e1).children().prop("checked", true);

                              // $(".all-print").show();
                          }else{

                              // console.log("un check"+$(e1).children().val());
                              $(e1).children().prop("checked", false);
                              $(document).find("input[name='selection_all']").prop("checked", false);
                              $(document).find("input[name='selection_all']").parent().removeClass("checked");
                          }
                          orderList = [];
                          $(".icheckbox_square-red input[name='selection[]']:checked").each(function(i,e){
                              orderList.push(e.value);
                          });
                           //console.log(orderList);
                          orderStatusList = [];
                          $(".icheckbox_square-red input[name='selection[]']:checked").each(function(i,e){
                              orderStatusList.push($(e).parents("tr").attr("data-status"));
                          });
                          // console.log(orderStatusList);
                      }else{
                          orderList = [];
                          if($(e1).children().prop("checked")){
                               console.log("check all");
                              $(".icheckbox_square-red input[name='selection[]']").each(function(i,e){
                                   console.log(e.value);
                                  $(e).prop("checked", true);
                                  $(e).parent().addClass("checked");
                                  orderList.push(e.value);
                              });
                          }else{
                              // console.log("un check all");
                              $(".icheckbox_square-red input[name='selection[]']").each(function(i,e){
                                  // console.log(e.value);
                                  $(e).prop("checked", false);
                                  $(e).parent().removeClass("checked");
                                  orderList = [];
                              });
                          }

                           //console.log(orderList);
                      }
                      // console.log(orderList);
                    //  alert(orderList[0]);
                      if(orderList.length > 0){
                        $(".btn-trasfer").attr("disabled",false);
                        $(".btn-trasfer").removeClass("btn-default");
                        $(".btn-trasfer").addClass("btn-primary");
                        $(".remove_item").html("["+orderList.length+"]");
                        $(".btn-view").attr('disabled',false);
                        $(".btn-update").attr('disabled',false);
                        $(".listid").val(orderList);
                        $("#items").html("สินค้าจำนวน "+orderList.length+" รายการ");

                        $(".btn-bulk-remove").removeClass("btn-default");
                        $(".btn-bulk-remove").addClass("btn-danger");
                        $(".btn-bulk-remove").attr('disabled',false);
                        $(".btn-printbarcode").attr('disabled',false);
                          $(".btn-print-stock").attr('disabled',false);
                          $(".btn-add-component").attr('disabled',false);
                          // console.log("niran");
                      }else{
                        $(".btn-trasfer").attr("disabled",true);
                        $(".btn-trasfer").removeClass("btn-primary");
                        $(".btn-trasfer").addClass("btn-default");
                        $(".remove_item").html("["+orderList.length+"]");
                        $(".btn-bulk-remove").attr('disabled',true);
                        $(".btn-view").attr('disabled',true);
                        $(".btn-update").attr('disabled',true);
                        $(".listid").val(orderList);
                        $("#items").html("สินค้าจำนวน "+orderList.length+" รายการ");
                        $(".btn-bulk-remove").addClass("btn-default");
                        $(".btn-bulk-remove").removeClass("btn-danger");
                        $(".btn-printbarcode").attr('disabled',true);
                          $(".btn-print-stock").attr('disabled',true);
                          $(".btn-add-component").attr('disabled',true);
                        //console.log("ddfdfdfd");
                      }
                  });
              });



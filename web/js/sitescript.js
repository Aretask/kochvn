$( document ).ready(function() {
    if($('#countOrderUser')){
        if($.cookie('indent')) {
            var indent = $.cookie('indent');
            $.ajax({
                method: "GET",
                url: "/product/count-orders",
                data: {indent: indent},
                dataType: "json"
            })
                .done(function (response) {
                    var count='';
                    if(response.count){
                      count=response.count;  
                    } 
                    $('#countOrderUser').text(count);
                });
        }
    }
  if($('#check_rubrik').length){
      $('#check_rubrik li').on('click',function(e){
          var href=$(e.target).attr('link');
          $('#view_more').attr('href',"/"+href);
      })
  }
    
    //made on category
if($('.selectpickerl').length){
    $('.selectpickerl').selectpicker({
        style: 'btn-default',
        size: 4,
        width:'100%',
        noneResultsText:"Ничего не найдено "
    });
      var  madeSelect=$('#madel').attr('made');
    $('.selectpickerl').selectpicker('val', madeSelect);

    $('.selectpickerl').on('change',function(e){
        var made=$('.selectpickerl').val();
        if(made!=0){
            made="/brand/"+made;
        }else{
            made='';
        }
        var href='';
        var slesh=location.pathname.substr(location.pathname.length - 1);
        var pathname=location.pathname;
        if(slesh=="/"){
           pathname=pathname.substr(0,pathname.length - 1); 
        }
        pathname=pathname.split("/");
        var length=pathname.length;
        if(new RegExp("/brand/").test(location.pathname)){
            if(length==3){
               href=made;  
            }
            if(length==4){
               href="/"+pathname[1]+made;
            }
            if(length==5){
              href="/"+pathname[1]+"/"+pathname[2]+made; 
            }
        }else{
            if(new RegExp("/item/").test(location.pathname)){
               href=made; 
            }else{
                if(!href && made){
                    href=made;   
                }
                if(length==2){
                  href=pathname[1]?"/"+pathname[1]+made:made;  
                }
                if(length==3){
                  href="/"+pathname[1]+"/"+pathname[2]+made;  
                }
            }
        }
        console.log(href)
       location.href=location.origin+href;

    })
}

//filters category
    if($('#filters')){
        $('#filters').on('submit',function(e){
           e.preventDefault(0);
           var data=$( this ).serializeArray();
           var patt = new RegExp("filter");
           var filters='';
           data.forEach(function(item){
               if(patt.test(item.name)){
                  if(filters)filters+=",";
                    filters+=item.value;
               }
           })
            $.ajax({
                method: "GET",
                url: "/ajax"+location.pathname+"?filters="+filters
            })
                .done(function (response) {
                    $('#product_category').empty();
                    $('#product_category').html(response);
                });
                window.history.replaceState( {} , $('title').text(), location.pathname+"?filters="+filters );
        });
        
        $('#filters').on('click',function(e){
            var type=$(e.target).attr('type');
            if(type=='checkbox'){
               $('#filters').trigger('submit');
            }
        });
        
        $('#clear_filter').on('click',function(e){
            $('#filters').find('input').prop('checked', false)
            $('#filters').trigger('submit');
        });
    }
//кнопка заказть товар
    if($('#order_button')){
        $('#form_order').on('submit',function(e){
            e.preventDefault(e);
            var indent=0;
            if($.cookie('indent')){
                indent= $.cookie('indent');
            }else{
                indent = new Date().getTime();
                $.cookie('indent', indent,{path:"/"});
            }
            $.ajax({
                method: "POST",
                url: "/product/set-order",
                data: $(e.target).serialize()+"&indent="+indent,
                dataType: "json"
            })
                .done(function( response ) {
                    if(response.status==1){
                       // console.log($('#countOrderUser'))
                       var countOrd= $('#countOrderUser').html();
                        countOrd=parseInt(countOrd);
                       // console.log(countOrd)
                        if(countOrd)countOrd++;
                        else countOrd=1;
                        $('#countOrderUser').text(countOrd);
                       alert('Товар добавлен в заказы');
                    }else if(response.status==2){
                        alert('Товар уже добавлен')
                    }
                });
        })

    }

    if($('#carousel-inner').length){
        $('#carousel-inner').on('click',function(e){
            var src=$(e.target).attr('src');
            if(src){
                src=src.replace('thumb','medium');
               $('#main_photo').attr('src',src); 
            }
        });
    }
    
    if($('#ordersTable').length){
        
        $('#checkAll').on('click',function(e){
            if($(e.target).attr('check')==0){
              $("#ordersTable input:checkbox").attr('checked','checked');  
              $(e.target).attr('check',1);
            }else{
              $("#ordersTable input:checkbox").attr('checked',false);  
              $(e.target).attr('check',0);
            }
        });
        if(localStorage!=undefined){
            $("#phoneNumber").val(localStorage.getItem('phone')?localStorage.getItem('phone'):"");
            $("#userName").val(localStorage.getItem('userName')?localStorage.getItem('userName'):"");
            $("#email").val(localStorage.getItem('email')?localStorage.getItem('email'):"");
        }
        
        $('.order_id').on('change',function(){
            var checked=$("#ordersTable input:checkbox:checked" );
            var price=0;
            if(checked.length){
                checked.each(function(index,item){
                   price+=parseInt($(item).parents('tr').find('.cart_total_price span').text());
                })
            }
            $('#total_sum').text(price); 
        });
        
        $('.number').on('click',function(e){
          var up=  $(e.target).hasClass('cart_quantity_up');
          var price=$(e.target).parents('td').prev().find('span').text();
          var price_total=$(e.target).parents('td').next().find('span');
          var change=false;
          if(up){
              var number=$(e.target).next().val();
              number++;
              $(e.target).next().val(number);
              var total=price*number;
              price_total.text(total);
              change=true;
          }else{
              var number=$(e.target).prev().val();
              if(number>1){
                  number--;
                  $(e.target).prev().val(number);
                  var total=price*number;
                  price_total.text(total); 
                  change=true;
              }
          }
          if(change){
              $('.order_id').trigger('change');
          }
        })
        $('#ordersTable').on('click',function(e){
            var delItem=$(e.target).attr('itemdel');
            if(delItem){
                $.ajax({
                    method: "POST",
                    url: "/product/del-order/",
                    data: {'delItem':delItem},
                    dataType: "json"
                })
                    .done(function(response) {
                       if(response.status==1){
                           $(e.target).parents('tr').remove();
                           var countOrd= $('#countOrderUser').text();
                           countOrd--;
                           if(!countOrd) {
                               countOrd='';
                           }
                           $('#countOrderUser').text(countOrd);
                           if($('#ordersTable').find('tr').length==1){
                               $('#order').remove();
                           }
                       }else{
                           alert('Перезагрузите страницу или попробуйте позже')
                       }
                    });
            }
        })


        //Форматирование телефона
        $("#phoneNumber").on('keypress',function(e){
            var target=$(e.target);
            var value=target.val();
            var chars=String.fromCharCode(e.charCode);
            var length=value.length;
            if(Boolean(String.fromCharCode(e.charCode).match(/[\d\(\)\-\+]/))){
                if(!value) {
                    if(chars==='8'){target.val("+3");}
                    else if(chars==='3'){target.val("+");}
                    else if(chars==='0'){target.val("+38(");}
                    else if(chars!=='+'){target.val("+38(0");}
                }else{
                    switch (length){
                        case 3:
                            target.val(value+"(");
                            break;
                        case 7:
                            target.val(value+")");
                            break;
                        case 11:
                        case 14:
                            target.val(value+"-");
                            break;
                        case 17:
                            target.val(value.substr(0,length-1));
                            break;
                    }
                }
            }else{
                if(e.keyCode==8){
                    target.val(value.substr(0,length));
                }else if(e.keyCode==46){
                    target.val(value);
                }else{
                    e.preventDefault(0);
                }
            }
        });
        $('#formOrderUser').on('submit',function(e){
            e.preventDefault(0);
             var checked=$( "#ordersTable input:checkbox:checked" );
            if(checked.length==0){
                alert('Пожалуйств, выберите товар.');
                return;
            } 
            if($("#phoneNumber").val().length==17){
                localStorage.setItem('phone',$("#phoneNumber").val());
                localStorage.setItem('userName',$("#userName").val());
                localStorage.setItem('email',$("#email").val());
            $.ajax({
                method: "POST",
                url: "/product/comfirm-order",
                data: $(e.target).serialize(),
                dataType: "json"
            })
                .done(function(response) {
                    if (response.status) {
                        response.result.forEach(function (item) {
                            $('#order_' + item).remove();
                        });
                        if ($('#ordersTable').find('tr').length == 1) {
                           $('#order').remove();
                           $('#formOrderUser').remove();
                        }
                        $('#goodOrder').removeClass('hide');
                        $('body').scrollTop();
                    }else{
                        alert('Сервер не отвечает. Перезагрузите страницу и попоробуйте еще раз')
                    }
                });
            }else{
                alert('Введите правильныый формат телефона!')
            }
        })

    }


    });

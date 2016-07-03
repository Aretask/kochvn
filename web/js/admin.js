 if($('#description').length){
    CKEDITOR.replace( 'description' );
 }
 
 if($('.delgallery').length){
     $('.delgallery').on('click',function(e){
         var delitem=$(e.target).attr('delgal');
         if(delitem){
               $.ajax({
                method: "GET",
                url: "/admin/default/del-gallery",
                data: {'photo':delitem},
                dataType: "json"
            }).done(function(response){
               if(response.status){
                   $(e.target).parent().remove();
               }
            })
         }
     });
 }

function setTruePrice(){
    var currency=$('#currency option:selected').attr('cur');
    $('#cur').text(currency);
    $('#setPrice').text(($('#priceSet').val()*currency));
    $('#price').val(($('#priceSet').val()*currency));
}
function countRealPrice(elem){
 $('#setPrice').text(($(elem).val()*$('#cur').text()));
 $('#price').val(($(elem).val()*$('#cur').text()))
}
function countRealPriceAction(elem){
 $('#setPriceAction').text(($(elem).val()*$('#cur').text()));
 $('#priceAction').val(($(elem).val()*$('#cur').text()))
}
function checkAllow(elem,type){
    if(type=='category'){
        if($(elem).parents('div').prev().find('select').val()==0){
          translitText(elem,$(elem).next())
        }
    }else if(type=="brand"){
       if($('#madeBrend').val()==0){
          translitText(elem,$('#eng'));
        } 
    }
}
function translitText(text,elem){
   var textTr=$(text).val();
   textTr=textTr.replace(/[^a-zA-ZА-Яа-я0-9\s]/g,"");
var transl=new Array();
    transl['А']='a';     transl['а']='a';
    transl['Б']='b';     transl['б']='b';
    transl['В']='v';     transl['в']='v';
    transl['Г']='g';     transl['г']='g';
    transl['Д']='d';     transl['д']='d';
    transl['Е']='e';     transl['е']='e';
    transl['Ё']='yo';    transl['ё']='yo';
    transl['Ж']='zh';    transl['ж']='zh';
    transl['З']='z';     transl['з']='z';
    transl['И']='i';     transl['и']='i';
    transl['Й']='j';     transl['й']='j';
    transl['К']='k';     transl['к']='k';
    transl['Л']='l';     transl['л']='l';
    transl['М']='m';     transl['м']='m';
    transl['Н']='n';     transl['н']='n';
    transl['О']='o';     transl['о']='o';
    transl['П']='p';     transl['п']='p';
    transl['Р']='r';     transl['р']='r';
    transl['С']='s';     transl['с']='s';
    transl['Т']='t';     transl['т']='t';
    transl['У']='u';     transl['у']='u';
    transl['Ф']='f';     transl['ф']='f';
    transl['Х']='x';     transl['х']='x';
    transl['Ц']='c';     transl['ц']='c';
    transl['Ч']='ch';    transl['ч']='ch';
    transl['Ш']='sh';    transl['ш']='sh';
    transl['Щ']='shh';    transl['щ']='shh';
    transl['Ъ']='';     transl['ъ']='';
    transl['Ы']='i';    transl['ы']='i';
    transl['Ь']='';    transl['ь']='';
    transl['Э']='E';    transl['э']='e';
    transl['Ю']='yu';    transl['ю']='yu';
    transl['Я']='ya';    transl['я']='ya';
    transl[' ']='-';     transl['\"']='';
    transl['\d']='';     transl['\'']='';
    transl['_']='';
    var result='';
    for(i=0;i<textTr.length;i++) {
        if(transl[textTr[i]]!=undefined) { result+=transl[textTr[i]]; }
        else { result+=textTr[i]; }
    }
       elem.val(result.toLowerCase())
}
$('#parseReady').on('submit',function(e){
     e.preventDefault();
     $('#spiner').removeClass('hide');
    var form_data = $(e.target).serializeArray();
        console.log(form_data)
            $.ajax({
                 dataType: 'json',
                type: "POST",
                url: "/admin/parse/parse-parse",
                data: form_data,
                dataType: "json"
            }).success(function(response){
            console.log(response)

            })
})
//Filter mode
$('#filterAdd').on('submit',function(e){
    e.preventDefault();
    var valFilter=$('#filter').val();
    var lengthItem=$('#filterView').find('h4').length;
    if($('#filterAdd input[name="productId"]').val()){
        if(lengthItem<4 || $('#filter'+valFilter).length){
        var data=$(e.target).serializeArray();
        var name=$('#filter option:selected').text();
        var nameItem=$('#filter_item option:selected').text();
         $.ajax({
                method: "GET",
                url: "/admin/products/set-filter-product",
                data: data,
                dataType: "json"
            }).done(function(response){
                if(response.affectedRows){
                    if($('#filter'+valFilter).length){
                         var itemClon= '<span class="label label-primary">'+nameItem+' </span>';
                        $('#filter'+valFilter).append(itemClon); 
                    }else{
                      var itemClon= '<h4>'+name+'------------<span id="filter'+valFilter+'"><span class="label label-primary">'+nameItem+'</span></span></h4>';
                      $('#filterView').append(itemClon);   
                    }
                }else{
                    var text='Не удалось добавить фильтр';
                   if(response.exist){ 
                       text="Такой фильтр к єтому товару уже существует";
                   }
                    alert(text)
                }

            })
        }else{
            alert('Можно добавить только 4 фильтра. Остальное можно дописать в характеристиках');
        }
    }else{
        alert('Добавьте  сначала товар');
    }
})

$('.delfilter').on('click',function(e){
e.preventDefault();
    var data={};
    data.filterIdDel=$(e.target).attr('filterIdDel');
         $.ajax({
            method: "GET",
            url: "/admin/products/set-filter-product",
            data: data,
            dataType: "json"
        }).done(function(response){
            if(response.affectedRows){
              var span=$(e.target).parents('span');
              $(e.target).prev().remove();  
              $(e.target).remove(); 
              if(!$(span).find('span').length){
                  $(span).parent().remove();    
              }
            }else{
                alert('Не удалось удалить фильтр')
            }
            
        })
})

//Modeficatiion Mode

$('#modeficationAdd').on('submit',function(e){
    e.preventDefault();
     if($('#modeficationAdd input[name="productId"]').val()){
        var data=$(e.target).serializeArray();
        var name=$('#nameSpecifications').val();
        var option=$('#valueSpecifications').val();
         $.ajax({
                method: "GET",
                url: "/admin/products/modefication-add",
                data: data,
                dataType: "json"
            }).done(function(response){
                if(response.affectedRows){
                   var row ='<div class="row"><div class="col-sm-3"><b>'+name+'</b></div>'+
                        '<div class="col-sm-7">'+option+'</div></div>';
                   $('#modeficationView').append(row);
                }else{
                    var text='Не удалось добавить фильтр';
                    alert(text)
                }

            })
     
    }else{
        alert('Добавьте  сначала товар');
    }
})

$('.delMod').on('click',function(e){
    e.preventDefault();
    var data={};
    data.modeficationIdDel=$(e.target).attr('delMod');
         $.ajax({
            method: "GET",
            url: "/admin/products/modefication-add",
            data: data,
            dataType: "json"
        }).done(function(response){
            if(response.affectedRows){
              $(e.target).parent().parent().remove();
            }else{
                alert('Не удалось удалить модификацию')
            }
            
        })
})

//Gallery Mode
$('#photoGalleryAdd').on('submit',function(e){
    console.log(e.target)
    e.preventDefault();
    var product_id=$('#photoGalleryAdd input[name="AddProductsGalleryForm[productId]"]').val();
     if(product_id){
           var form_data = new FormData($("#photoGalleryAdd")[0]);
         $.ajax({
                 dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                type: "POST",
                url: "/admin/products/add-gallery",
                data: form_data,
                 dataType: "json"
            }).success(function(response){
                if(response.photo){
                    var div=$('<div/>',{'class':"col-xs-3"});
                    var img=$('<img/>',{'class':"img-thumbnail","style":"height:115px",'src':response.photo});
                    div.append(img);
                   $('#galerryView').append(div);
                }else{
                    alert('Фото не добавилось!');
                }

            })
     
    }else{
        alert('Добавьте  сначала товар');
    }
})

$('.photoDel').on('click',function(e){
    e.preventDefault();
    var data={};
    data.photoDel=$(e.target).attr('photoImageDel');
         $.ajax({
            method: "GET",
            url: "/admin/products/del-photo-gallery",
            data: data,
            dataType: "json"
        }).done(function(response){
            if(response.affectedRows){
              $(e.target).parent().parent().remove();
            }else{
                alert('Не удалось удалить фото')
            }
            
        })
})


//--------------------------------------------------//
if($('#rubric').length){
$('#rubric').on('change',function(e,done){
    var rubricId=$(e.target).val();
        if(rubricId!=0){
             $.ajax({
            method: "GET",
            url: "/admin/products/get-category",
            data: {rubricId:rubricId},
            dataType: "json"
        })
            .done(function(response) {
                $('#category').empty();
                response.forEach(function(item){
                $('#category').append("<option value='"+item.categoryId+"'>"+item.name+"</option>");
                })
                if(done && done.done){
                    var select=$('#made option:selected' );
                    var catArray=select.attr('cat').split(",");
                    catArray.forEach(function(item){
                        if($.trim(item)){
                           $('#category option[value="'+item+'"]').attr('selected','selected')
                        }
                    })
                }
            });
        }
    })

}

    if($('#editMade').length){
        $('#editMade').on('click',function(e){
            $('#madeBrend').val($('#made').val());
            var select=$('#made option:selected' );
            $('#nameCompany').val(select.text());
            $('#eng').val(select.attr('eng'));
            $('#company_add').text('Сохранить');
        })
    }

if($('#categoryChange').length){
  $('#categoryChange').find('select').on('change',function(e){
      var parent=$(e.target).parent().parent();
      if($(e.target).val()!=0){
          var text=$(e.target).find('option:selected').text();
          var order=$(e.target).find('option:selected').attr('order');
          var eng=$(e.target).find('option:selected').attr('eng');
          parent.find('[name="name"]').val(text);
          parent.find('[name="eng"]').val(eng);
          parent.find('[name="orderCat"]').val(order);
        parent.find('.redug').attr('disabled',null);  
        parent.find('.add').attr('disabled','disabled');  
      }else{
          parent.find('[name="name"]').val('');
          parent.find('[name="orderCat"]').val('');
          parent.find('[name="eng"]').val('');
        parent.find('.redug').attr('disabled','disabled');  
        parent.find('.add').attr('disabled',null);  
      }
  })
    
}

if($('.completeorder').length){
  $('.completeorder').on('click',function(elem){
      var idbuyer=$(elem.target).attr('idbuyer');
      if(idbuyer){
                $.ajax({
            method: "GET",
            url: "/admin/orders/complete-order/",
            data: {idbuyer:idbuyer},
            dataType: "json"
        })
            .done(function(response) {
                if(response.status){
                  $(elem.target).parents('tr').remove();
                  $('#good').removeClass('hide');
                  setTimeout(function(){
                     $('#good').addClass('hide'); 
                  },2000)
                }
            })
      }
  })
  
}

if($('.addBlack').length){
  $('.addBlack').on('click',function(elem){
      var idbuyer=$(elem.target).attr('idbuyer');
      if(idbuyer){
                $.ajax({
            method: "GET",
            url: "/admin/orders/black-list-buyer/",
            data: {idbuyer:idbuyer,status:1},
            dataType: "json"
        })
            .done(function(response) {
               if(response.status==1){
                   $(elem.target).prev().attr('disabled',null);
                   $(elem.target).attr('disabled','disabled');
                  $(elem.target).parents('tr').addClass('black');
               }
            })
      }
  })
  
}

if($('.dellBlack').length){
  $('.dellBlack').on('click',function(elem){
      var idbuyer=$(elem.target).attr('idbuyer');
      if(idbuyer){
                $.ajax({
            method: "GET",
            url: "/admin/orders/black-list-buyer/",
            data: {idbuyer:idbuyer,status:0},
            dataType: "json"
        })
            .done(function(response) {
                 if(response.status==1){
                   $(elem.target).next().attr('disabled',null);
                   $(elem.target).attr('disabled','disabled');
                  $(elem.target).parents('tr').removeClass('black');
               }
            })
      }
  })
  
}
//Search Products
    $('#searchProduct').on('submit',function(e,page){
            if(!page) page=1;
            e.preventDefault();
            if($('#searchProduct').find('[name=suplier]').val() || $('#searchProduct').find('[name=category]').val()|| $('#searchProduct').find('[name=productId]').val() ){
            var data=$(e.target).serializeArray();
            $.ajax({
                method: "GET",
                url: "/admin/products/search?page="+page,
                data: data
            })
            .done(function(response) {
                $('#allInput').attr('checked',null);
                $('#containerProducts').empty();
                $('#containerProducts').append(response)
            });
            }else{
                alert('Ничего не выбрано');
            }
        })
        
        //Установка изменений
    $('#setChangeProducts').on('submit',function(e){
            e.preventDefault();
            var idsSet=[];
             var inputs= $('#containerProducts').find('input:checked'); 
             if($('#setChangeProducts').find('[name=number]').val() && inputs.length>0){
                var data=$(e.target).serializeArray();
                $.each(inputs,function(index,item){
                    var id=$(item).val();
                    idsSet.push(id); 
                }) 
                data.push({name:'idsSet',value:idsSet})
                if(idsSet.length>0){
                        $.ajax({
                    method: "GET",
                    url: "/admin/products/set-new-param",
                    data: data
                })
                .done(function(response) {
                    if(response){
                       $('#searchProduct').trigger('submit');  
                    }
                }); 
                }
            }else{
                alert('Ничего не выбрано');
            }
        })
        
            $('#setChangeProductsFilter').on('submit',function(e){
            e.preventDefault();
            var idsSet=[];
             var inputs= $('#containerProducts').find('input:checked'); 
             if($('#filter_item').val() && inputs.length>0){
                var data=$(e.target).serializeArray();
                $.each(inputs,function(index,item){
                    var id=$(item).val();
                    idsSet.push(id); 
                }) 
                data.push({name:'idsSet',value:idsSet})
                if(idsSet.length>0){
                        $.ajax({
                    method: "GET",
                    url: "/admin/products/set-filter-product",
                    data: data
                })
                .done(function(response) {
                    if(response){
                       alert('Добавлено');
                    }
                }); 
                }
            }else{
                alert('Ничего не выбрано');
            }
        })
        
        
   $('.delProduct').on('click',function(e){
       var idsDel=[];
       if($(e.target).attr('delId')){
           idsDel.push($(e.target).attr('delId'));
       }else{
        var inputs= $('#containerProducts').find('input:checked'); 
        $.each(inputs,function(index,item){
            var id=$(item).val();
           idsDel.push(id); 
        })   
       }
    
       if(idsDel.length>0){
         $.ajax({
                method: "GET",
                url: "/admin/products/del-product",
                data: {idsDel:idsDel}
            })
            .done(function(response) {
               idsDel.forEach(function(item){
                   $('#item'+item).remove();
               }) 
            });  
       }
   })

//TMP PARSE FILE 
$('#parseFile').on('submit',function(e){
     e.preventDefault();
     var form_data = new FormData();  
        var file_data = $("#fileProduct").prop("files")[0];   
        var type = $("#typeFile").val();   
	form_data.append("fileProduct", file_data); 
	form_data.append("type", type); 
         $.ajax({
                 dataType: 'script',
                cache: false,
                contentType: false,
                processData: false,
                type: "POST",
                url: "/admin/parse/parse-file",
                data: form_data,
                 dataType: "json"
            }).success(function(response){
                var div3={};
                var select={};
                var products=response.data;
                $.each(products,function(item,index){
                if(typeof index =="object"){
                    createRowParse(index)
                }else{
                   createRowParse(item,index);
                }
                })
                $('#createFile').removeClass('hide');
                $('#parseProductFile').val(response.file);
            })
})

function createRowParse(products,item){
    if(typeof products =="object"){
        $.each(products,function(index,item){
          setRows(index,item)
        })
    }else{
        setRows(products,item)
    }
}

    function setRows(products,item){
        var select=$('#cloneSelect').clone(true);
        $(select).removeClass('hide');
        $(select).find('select').attr('name','LoadParseFileForm['+products+']');
        var div= $('<div/>',{
            'class':'row border'
        });
        var div3= $('<div/>',{
            'class':'col-xs-5',
            html:"<strong>"+products+"</strong>: "+item
            });
        div.append(div3);
        div.append(select);
        $('#parseProduct').append(div);
    }

     $('.selectType').on('change',function(e){
            var type=$(e.target).val();
            if(type){
                $(e.target).parents('div.border').addClass('font'); 
            }else{
               $(e.target).parents('div.border').removeClass('font') ; 
            }
        })
        
   $('#suplierTmp').on('change',function(e){
          var suplierId=$(e.target).val();
        if(suplierId!=0){
            $('#suplierValue').val(suplierId);
             $.ajax({
            method: "GET",
            url: "/admin/parse/category-tmp",
            data: {suplierId:suplierId},
            dataType: "json"
        })
            .done(function(response) {
                $('#categoryTmp').empty();
                $('#madeTmp').empty();
                $('#categoryTmp').append("<option value=''>Выбрать</option>");
                $('#madeTmp').append("<option value=''>Выбрать</option>");
                response.category.forEach(function(item){
                $('#categoryTmp').append("<option value='"+item.valueProduct+"'>"+item.valueProduct+"</option>");
                })
                response.brand.forEach(function(item){
                $('#madeTmp').append("<option value='"+item.valueProduct+"'>"+item.valueProduct+"</option>");
                })
            });
        }else{
             $('#suplierValue').val(0);
        }
   })
   
     $('#searchProductTmp').on('submit',function(e){
            e.preventDefault();
            if($('#searchProductTmp').find('[name=suplier]').val() || $('#searchProductTmp').find('[name=category]').val()|| $('#searchProductTmp').find('[name=made]').val() ){
            var data=$(e.target).serializeArray();
            $.ajax({
                method: "GET",
                url: "/admin/parse/search-tmp",
                data: data
            })
            .done(function(response) {
                $('#allInput').attr('checked',null);
                $('#containerProducts').empty();
                $('#containerProducts').append(response)
            });
            }else{
                alert('Ничего не выбрано');
            }
        })
        
            $('#moveProductsTmp').on('submit',function(e){
            e.preventDefault();
            var idsSet=[];
             var inputs= $('#containerProducts').find('input:checked'); 
             if(inputs.length>0){
                var data=$(e.target).serializeArray();
                $.each(inputs,function(index,item){
                    var id=$(item).val();
                    idsSet.push(id); 
                }) 
                data.push({name:'idsSet',value:idsSet})
                if(idsSet.length>0){
                        $.ajax({
                    method: "GET",
                    url: "/admin/parse/move-products-tmp",
                    data: data
                })
                .done(function(response) {
                    if(response){
                       $('#searchProductTmp').trigger('submit');  
                       alert('Готово');
                    }
                }); 
                }
            }else{
                alert('Ничего не выбрано');
            }
        })
       $('.delProductTmp').on('click',function(e){
       var idsDel=[];
        var inputs= $('#containerProducts').find('input:checked'); 
        $.each(inputs,function(index,item){
            var id=$(item).val();
           idsDel.push(id); 
        })   
    
       if(idsDel.length>0){
         $.ajax({
                method: "GET",
                url: "/admin/parse/del-product-tmp",
                data: {idsDel:idsDel}
            })
            .done(function(response) {
               idsDel.forEach(function(item){
                   $('#item'+item).remove();
               }) 
            });  
       }
   })
   
  
   


 
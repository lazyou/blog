 /**
  * ajax 辅助函数 【异步】
  * @param {*} url 
  * @param {*} type 
  * @param {*} data 
  * @param {*} dataType 
  */
 function ajaxAsync(url, type, data, dataType) {
     if (!type) {
         type = 'GET';
     }

     if (!data) {
         data = {};
     }

     if (!dataType) {
         dataType = 'json';
     }

     var result = $.ajax({
         url: url,
         type: type,
         data: data,
         async: true,
         dataType: dataType
     });

     return result;
 }


/**
 * ajax 辅助函数 【同步】
 * @param {*} url 
 * @param {*} type 
 * @param {*} data 
 * @param {*} successDeal 
 * @param {*} errorDeal 
 */
function ajaxHelper(url, type, data, successDeal, errorDeal) {
    var result = {};
    $.ajax({
        url: url,
        type: type,
        data: data,
        async: false,
        dataType: "json",
        success: function (response, textStatus, xhr) {
            result.status = xhr.status;
            result.is_true = true;
            result.data = xhr.responseJSON;
            if (isFunction(successDeal)) {
                successDeal();
            };
        },
        error: function (xhr, textStatus, error) {
            result.status = xhr.status;
            result.is_true = false;
            result.data = xhr.responseJSON;
            if (isFunction(errorDeal)) {
                errorDeal();
            };
        }
    });
    return result;
}
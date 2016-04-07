/**
 * Created by Steven on 2015/06/24/0024.
 */

/**
 * Check a field is unique or not
 * @param url The url of the destination address
 * @param obj The post property
 * @returns {number} -1: is default, http error, 0: false, this field is not unique, 1: The field is unique
 */
function checkUnique(url, obj, callBack) {
    var isUnique = -1;
    $.get(url, obj, function (data, status) {
        if (status == 'success') {
            isUnique = data;
            return callBack(isUnique);
        }
    });

}

/**
 *
 * @param e System Event
 */
function preventDefault(e) {
    e.preventDefault();
}

/**
 *
 * @param size count of page items
 * @param count count in database
 * @returns {number}
 */
function getPageCount(size, count) {
    var pageCount = 0;
    if (count == 0 || size == 0) {
        return 0;
    } else {
        pageCount = count / size;
        if ((pageCount + 1) / parseInt(pageCount + 1) == 1) {
            return pageCount;
        } else {
            return parseInt(pageCount) + 1
        }
    }
}

/**
 * this part for submit form with post method
 */
$(document).on('click','input[type=submit]',function(){

    var _this = $(this);
    var action=_this.parents('form').attr('action');
    var data = _this.parents('form').serialize();

    $.post(action,data,function(data, status){

        if(status == 'success'){
            switch (data){
                case 0:
                    layer.alert('操作失败，请重试!', {
                        icon:2,
                        skin: 'layui-layer-lan'
                    }, function(){
                        layer.closeAll('index');
                    });
                    break;
                case 1:
                    layer.alert('操作成功!', {
                        icon:1,
                        skin: 'layui-layer-lan'
                    }, function(){
                        layer.closeAll();
                    });
                    break;
                default :
                    break;
            }
        }
    });
});
function loading_list(page,url,tem_id,append_id,catid){
	if (!loadingLock) {			
		
				
        var _url =root_url+ url+'/page/' + parseInt(page)+'/catid/' + parseInt(catid);
        
        listLoading = true;
        $('.emptyTip').html('');
        $('#list-loading').show();
        $.get(_url, function(d) {
            console.log(_url);
            console.log(d);
            $('#list-loading').hide();
            if (d == '') {                   
                loadingLock = true;
            } else if (d !='') {
               
                var data ={
                    list:d
                };            

                var html = template(tem_id, data);     
                            
                $("#"+append_id).append(html);   
               
            }
            listLoading = false;            
        });
    }	
}

function scroll_load(url,tem_id,append_id,catid){
	console.log(1);
	loadingLock = false;
    // 初始化加载列表
    window.pdPageNo = 0;
    window.listLoading = false;     
    
    loading_list(pdPageNo,url,tem_id,append_id,catid);
   $(window).off('scroll');
    $(window).scroll(function() {
        totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop()) + 150;
        if ($(document).height() <= totalheight && !listLoading) {
            //加载数据
            loading_list(++pdPageNo,url,tem_id,append_id,catid);
        }
    });
}

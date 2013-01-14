function delModel(obj, message){
	
	if(!message){
		message = '确定要删除吗？';
	}

	if(obj){
		var delhref= obj.toString();
		if(confirm(message)){
			window.location.href = delhref;
		}else{
			return false;
		}
	}else{
		if(confirm(message)){
			document.forms[0].submit();
		}else{
			return false;
		}
	}
}
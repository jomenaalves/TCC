class Utils{

    qsA(selectorName){
        const element = document.querySelectorAll(selectorName);

        return element;
    }
    qs(selectorName){
        const element = document.querySelector(selectorName);

        return element;
    }
    
    validatesEmail(email) {

        const user = email.substring(0, email.indexOf("@"));
        const domain = email.substring(email.indexOf("@")+ 1, email.length);

        if (user.length >=1 && domain.length >=3 && domain.search("@")==-1 
            && domain.search("@")==-1 && domain.search(" ")==-1 && domain.search(" ")==-1 
            && domain.search(".")!=-1 && domain.indexOf(".") >=1 
            && domain.lastIndexOf(".") < domain.length - 1) {
            return true;
        }

        return false;
    }

    $(selector) {
        const element =  document.querySelector(selector);
        
        return element;
    }

    on(event, element,fnCallBack) {
        element.addEventListener(event, (e) => {
            fnCallBack(e);
        })
    }
}
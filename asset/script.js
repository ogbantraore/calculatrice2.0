function calculer(nb1,nb2,op){
    if(op == "+"){
        return nb1+nb2;
    }else if(op == "-"){
        return nb1-nb2;
    }else if(op == "x" || op=="*"){
        return nb1*nb2;
    }else if(op == "/"){
        return nb1/nb2;
    }
}
function gethistorique(){
    let httpGet = new XMLHttpRequest();
    httpGet.onreadystatechange = function(){
        if(httpGet.readyState === 4){
            if(httpGet.status === 200){
                response = JSON.parse(httpGet.responseText);
                let historique = document.querySelector('.historique1')
                historique.innerHTML = '';
                let displaye = document.querySelector(".displaye");
                //let operation = document.querySelector(".screen-operation");
                response.forEach(element => {
                    createHistorique(historique,element['operation'],element['result']);
                    let historique_elems = document.querySelectorAll('.historique-card');
                    if(historique_elems != undefined){
                        for (let i = 0; i < historique_elems.length; i++) {
                            (function(i){
                                historique_elems[i].addEventListener('click',function(){
                                    let spanop = this.querySelector(".op");
                                    displaye.innerText=spanop.innerText;
                                });
                            })(i);
                            
                        }
                        
}
                });
            }else{
                alert('erreur reponse');
            }
        }
    }
    httpGet.open("GET",'./addcalcule.php?c=1',false);
    httpGet.send();
}
function createHistorique(parent,operation,resulta){
    
    let div_hc = document.createElement('div');
    div_hc.setAttribute('class','historique-card');
    let div_he = document.createElement('div');
    div_he.setAttribute('class','historique-elem');
    div_he.innerHTML = '<span class="op">'+operation+'</span> = <span> '+resulta+'</span>';
    div_hc.appendChild(div_he);
    parent.appendChild(div_hc);
    

}

function search(elem,ensemle){
    for(let i=0;i < ensemle.length;i++){
        if(elem == ensemle[i]){
            return true;
        }
    }
    return false;
}

function simplify(phrase){
    let nombres = []; 
    let chaine = "";
    for(let i = 0; i < phrase.length;i++){
        
        if(search(phrase[i],"0123456789."))
        {
            chaine+=phrase[i];
        }else if(search(phrase[i],"/x*-+")){
            if(chaine.length > 0){
                nombres.push(chaine);
                chaine="";
            }
            nombres.push(phrase[i])
        }
    }
    if(chaine.length > 0){
        nombres.push(chaine);
        chaine="";
    }
    let matrix = nombres;
    return matrix;
}

function reverse(matrix){
    let matrix_reverse = [];
    while(matrix.length > 0){
        matrix_reverse.push(matrix.pop());
    }
    return matrix_reverse;
}

function calcule_gene(matrix,symb){
    let result = 0;
    let elem;
    let temp = [];
    let op = "";
    let i = 0;
    let matrix_sortie = [];
    matrix = reverse(matrix);
    while(matrix.length>0){
        elem = matrix.pop();
        if(search(elem,symb)){
            let locale = matrix_sortie.pop();
            temp.push(locale);
            temp.push(matrix.pop());
            if(temp.length>1){
                let second = Number(temp.pop());
                let first = Number(temp.pop());
                let result = calculer(first,second,elem);
                if(result == undefined || Number.isNaN(result) == true ){
                    return undefined
                }
                matrix_sortie.push(result);
            }
            
        }else{
            matrix_sortie.push(elem);
        }
    }
    if(matrix_sortie.length<1)
        return undefined
    return matrix_sortie;
}

function calcule(matrix){
    
    matrix = calcule_gene(matrix,"x*/");
    matrix = calcule_gene(matrix,"-+");
    if(matrix != undefined)
        return matrix.pop();
    return undefined
}
function suppre(operation,displaye){
    let chaine="";
    //operation.innerText = chaine;
    for(let i=0;i<displaye.innerText.length-1;i++){
        chaine+=displaye.innerText[i];
    }
    return chaine;
}
let inputs = document.querySelectorAll(".form-input input");
if(inputs != undefined){

    for(let i=0;i<inputs.length;i++){
        (function(i){
            inputs[i].addEventListener("focus",function(){
                let label = this.parentElement.firstElementChild;
                if(label != undefined)
                    label.classList.add("focused");
            });
            inputs[i].addEventListener("blur",function(){
                let label = this.parentElement.firstElementChild;
                if(label != undefined)
                    if(this.value == "")
                        label.classList.remove("focused");
            });
        })(i);
    }
    let submit = document.querySelector(".submit");
    if(submit != null)
    submit.addEventListener("click",function(e){
        for(let i=0;i<inputs.length;i++){
            (function(i){
                let value = inputs[i].value;
                if(value == ""){
                    let label = inputs[i].parentElement.firstElementChild;
                    label.style.color ="#ff6b81";
                    e.preventDefault();
                }

            })(i);
        }
        if(inputs.length > 3){
            let pass1 = inputs[1].value;
            let pass2 = inputs[2].value;
            if(pass1 != pass2){
                alert("Les mot de passe ne coresponde pas");
                e.preventDefault();
            } 
        }
    });
}


let pad_btns = document.querySelectorAll(".pad button");
if(pad_btns != undefined){
    gethistorique();
    let displaye = document.querySelector(".displaye");
    let operation = document.querySelector(".screen-operation");
    
    
    for(let i=0;i<pad_btns.length;i++){
        (function(i){
            pad_btns[i].addEventListener("click",function(){
                this.style.transform ="scale(.8)";
                let a = this;
                setTimeout(function(){
                    a.style.transform ="scale(1)";
                    a.style.transform ="";
                },300)
                if(search(this.innerText,"0123456789/x-+") ){
                    displaye.innerText+=this.innerText;
                }
                else if(search(this.innerText,"C")){
                    displaye.innerText = "";
                    operation.innerText = ""
                }
                else if(search(this.innerText,"<")){
                    
                    displaye.innerText = suppre(operation,displaye);
                }
                else if(search(this.innerText,"=")){
                    let result = calcule(simplify(displaye.innerText));
                    
                    if(result != undefined){
                        let op="";
                        op+=displaye.innerText;
                        let tmp_op = op;
                        let tmp_resulte = result;
                        operation.innerText = op +" = "+result;
                        displaye.innerText = result
                        let httpRequest = new XMLHttpRequest();
                        httpRequest.onreadystatechange = function(){
                            if(httpRequest.readyState === 4){
                                if(httpRequest.status === 200){
                                    //alert(httpRequest.responseText);
                                }else{
                                   // alert('erreur reponse');
                                }
                            }
                        }
                        httpRequest.open("POST",'./addcalcule.php',true);
                        let formdata = new FormData();
                        formdata.append('operation',tmp_op);
                        formdata.append('result',tmp_resulte);
                        httpRequest.send(formdata);
                        gethistorique();
                        
                        

                    }
                }
            });
        })(i);
    }
    
    document.body.addEventListener("keyup",function(e){
        e.preventDefault();
        let caracter = e.key;
        //console.log(e);
        if(search(caracter,"0123.654789/*x-+"))
        {
            displaye.innerText+=caracter;
        }else if(e.keyCode == 8){
            displaye.innerText =  suppre(operation,displaye);
        }else if(e.keyCode == 13){
            let result = calcule(simplify(displaye.innerText));
            if(result != undefined){
                
                let op="";
                op+=displaye.innerText;
                let tmp_op = op;
                let tmp_resulte = result;
                operation.innerText = op+" = "+result;
                displaye.innerText = result

                let httpRequest = new XMLHttpRequest();
                httpRequest.onreadystatechange = function(){
                    if(httpRequest.readyState === 4){
                        if(httpRequest.status === 200){
                            alert(httpRequest.responseText);
                        }else{
                            alert('erreur reponse');
                        }
                    }
                }
                httpRequest.open("POST",'./addcalcule.php',true);
                let formdata = new FormData();
                formdata.append('operation',tmp_op);
                formdata.append('result',tmp_resulte);
                httpRequest.send(formdata); 
                
                gethistorique();
                

            }
        }
    });

    
}

let historique = document.querySelectorAll(".toggle");
if(historique != undefined){
    for (let i = 0; i < historique.length; i++) {
        (function(i){
            historique[i].addEventListener("click",function(){
                let barre_historique = document.querySelector(".historique-content");
                barre_historique.classList.toggle("hide")
            });
        })(i)
        
    }
    
}



/*
<div class="historique-card">
                
    <div class="historique-elem"><span class="op"><?=$result["operation"]?></span> = <span> <?=$result["result"]?></span></div>

</div>
*/
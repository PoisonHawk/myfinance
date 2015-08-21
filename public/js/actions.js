var actions = {
    
    income: function (){
        console.info('income');
        
       var id = Math.round(Math.random(100)*10000);
       
       console.log(id);
       
        var str ='';    
        str += '<div class="modal fade"  id="modal_'+id+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
        str += '<div class="modal-dialog">';
        str += '<div class="modal-content">';
        str += '<div class="modal-header">';
        str += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
    //    str += '<h4 class="modal-title"></h4>
        str += '</div>';
        str += '<div class="modal-body">';

        str += '</div>';
        str += '<div class="modal-footer">';
        str += '<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>';        
        str += '</div>';
        str += '</div></div></div>';

        $('body').append(str);
        
         $('#modal_'+id+' .modal-body').load('/operations/create?type=income');
        
        $('#modal_'+id).modal('show');
       
    },
    
    outcome: function(){
        console.info('outcome');
    },
    
    transfer: function(){
        console.info('transfer');
    },
    
    
}



/**
 *  CRUD ajax list helper
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
ListAjaxEditor = function (options) {
    
    this.options = {
                'container': $('body')
            };
    $.extend( this.options, options );
    
    this.init();
}

ListAjaxEditor.prototype = {
    
    init: function() {
        var self = this;
        $(self.options.container).find('[data-btn-type=edit]').click(function(){
            var url = $(this).attr('href');
            if (!url && $(this).attr('data-href')) {
                url = $(this).attr('data-href');
            }
                
            self.editItem(url, $(this).attr('data-title'));
            return false;
        });
        
        $(self.options.container).find('[data-btn-type=add]').click(function(){
            var url = $(this).attr('href');
            if (!url && $(this).attr('data-href')) {
                url = $(this).attr('data-href');
            }
            
            self.editItem(url, $(this).attr('data-title'));
            return false;
        });
        
        $(self.options.container).find('[data-btn-type=delete]').click(function(){
            var url = $(this).attr('href');
            if (!url && $(this).attr('data-href')) {
                url = $(this).attr('data-href');
            }
            
            self.deleteItem(url, $(this).attr('data-title'));
            return false;
        });  
    },
    
    editItem: function(url, title) {
        var self = this;
        $.ajax({
            'url': url,
            'success': function(result, textStatus, xhr) {
                if (xhr.status!=200 || result=='') {
                    location.reload();
                    return;
                }
                
                self.showEditModal(title, result);
            },
            'complete': function(xhr, textStatus) {
                if (xhr.status!=200) {
                    location.reload();
                    return;
                }
            }
        });
    },
    
    deleteItem: function(url, title) {
        var self = this;
        self.showDeleteModal(url, title);
    },
    
    showDeleteModal: function(deleteUrl, title) {
       $('#deleteModalBlock .delete-btn').attr('href', deleteUrl);
       $('#deleteModalBlock .modal-title').html(title);
       $('#deleteModalBlock').modal('show');
    },
    
    showEditModal: function(title, result) {
       var self = this;
       
       $('#editModalBlock .modal-title').html(title);
       $('#editModalBlock .modal-body').html(result);
       if (!$('#editModalBlock:visible').length) {
         $('#editModalBlock').modal('show');
       }
       
       $('#editModalBlock form').find('a[data-btn-type=edit]').click(function(){
            self.editItem($(this).attr('href'), title);
            return false;
        });
       
       if (self.options['afterShow']) {
           self.options['afterShow']();
       }
       
       $('#editModalBlock form').submit(function(){
            var form = this;
            if ($(form).attr('data-state')=='onload') {
                return false;
            }
            
            $(form).attr('data-state', 'onload');
            
            
            $.ajax({
                'url': $(form).attr('action'),
                'method': $(form).attr('method'),
                'data': $(form).serialize(),
                'success': function(result, textStatus, xhr) {
                    if (xhr.status!=200 || result=='') {
                        location.reload();
                        return;
                    }
                    
                    self.showEditModal(title, result);
                },
                'complete': function(xhr, textStatus) {
                    if (xhr.status!=200) {
                        location.reload();
                        return;
                    }
                }
            });     
           return false;
       });
    }
    
}
$(function () {
    $.nette.init();
    
    $(document).ready(function() {
            
        
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
        
        // Overeni uzivatele
        i_CheckCustomer();
        i_Filter_main_page();
    })
})

function i_CheckCustomer()
{   
    $(".check-customer").click(function(event) {
        event.preventDefault();
        var email = $("#frm-customerInForm-email").val();
        var hash = $("#frm-customerInForm-hash").val();
        
        if (email != '') {
            $.nette.ajax({
                type: "POST", 
                data: {'email': email, 'hash': hash},
                url: {link sendhash!}
            }).done(function(response){
                i_CheckCustomerHash();
            })                                              
        }    
    })
}

function i_CheckCustomerHash()
{
    $(".check-customer-hash").click(function(event) {
        event.preventDefault();
        var email = $("#frm-customerInForm-email").val();
        var hash = $("#frm-customerInForm-hash").val();
        
        if (email != '') {
            $.nette.ajax({
                type: "POST", 
                data: {'email': email, 'pass': hash},
                url: {link sendhashauth!}
            });                                              
        }    
    })
}

function i_Filter_main_page()
{
    $(".filters").after($(".mainpage.page .subheader"))
}
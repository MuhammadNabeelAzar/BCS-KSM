function deletecategory(categoryid) {
    var catId = categoryid;
    
    $(document).ready(function () {
        $('#deleteCategoryModal').modal('show');
        $('#CategoryId').val(catId);
        
    });
}
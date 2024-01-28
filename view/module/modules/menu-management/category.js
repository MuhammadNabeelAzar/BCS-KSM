function deletecategory(categoryid) {
    //this function deletes item categories
    const catId = categoryid;
    
    $(document).ready(function () {
        $('#deleteCategoryModal').modal('show');
        $('#CategoryId').val(catId);
        
    });
}
var Student = {
  get_students: function(){
      RestClient.get('students', function(data){
        Utils.datatable('table_content', [
          {'data':'name','title': 'Name'},
          {'data': 'surname', 'title': 'Surname'},
          {'data': 'phone_number', 'title': 'Phone Number'},
          {'data': 'email', 'title': 'Email'},
          {'data': 'delete_student', 'title': 'Delete'}
        ], data);
      }, function(data){
        toastr.error(data.responseText);
      });

    /*  $.ajax({
         url: "rest/students",
         type: "GET",
         beforeSend: function(xhr){
           xhr.setRequestHeader('authorization', 'Bearer ' +  localStorage.getItem("user_token"));
         },
         success: function(data) {
           Utils.datatable('table_content', [
             {'data':'name','title': 'Name'},
             {'data': 'surname', 'title': 'Surname'},
             {'data': 'phone_number', 'title': 'Phone Number'},
             {'data': 'email', 'title': 'Email'},
             {'data': 'delete_student', 'title': 'Delete'}
           ], data);

          /* if($.fn.dataTable.isDataTable('#table_content')){
             $('#table_content').DataTable().destroy();
           }

            $("#table_content").DataTable({
              data: data,
              columns: [
                {'data':'name','title': 'Name'},
                {'data': 'surname', 'title': 'Surname'},
                {'data': 'phone_number', 'title': 'Phone Number'},
                {'data': 'email', 'title': 'Email'},
                {'data': 'delete_student', 'title': 'Delete'}
                ],
              "pageLength": 10,
              "lengthMenu": [2, 5, 10, 25, 50, "All"]
            });

         },
         error: function(data){
           toastr.error(data.responseText);
         }
       });*/
      }
}

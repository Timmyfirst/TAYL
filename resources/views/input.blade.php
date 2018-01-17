<html>
    <header>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script>
              window.Laravel = {!! json_encode([
                   'csrfToken' => csrf_token(),
               ]) !!};
        </script>

    </header>


    <body>
        <div>
            <div>
                <form id="input-url">
                    {{ csrf_field() }}
                    <label>URL:</label>
                    <input type="url" name="url" required/>
                    <input type="hidden" name="${_csrf.parameterName}" value="${_csrf.token}"/>
                </form>
            </div>

            <div>
                <button id="sender">Envoyer</button>
            </div>

        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <script>

        /** Envoi de l'input **/

            var $inputSenderFunction = null;
            $('#sender').on('click', function () {

                sendUrl($(this));
            });

            var sendUrl = function () {
                $data = $('#input-url input[type="url"]');
                console.log($data);
                console.log('ta mere');
                $inputSenderFunction = $.ajax({
                    url: '/input',
                    type: 'POST',
                    data: $data,
                    dataType: 'json',
                    beforeSend: function () {
                        // console.log('beforesend');
                        // $btn.html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Creating...');
                    },
                    complete: function () {
                        // console.log('complete');
                        // $addNewTask_xhr = null;
                        // $btn.html('<i class="fa fa-check"></i> Create');
                    },
                    success: function (json) {
                        // console.log('success');
                        //console.log(json);
                        /*
                        toastr.success(json.message);
                        $('#add_new_email_storage').modal('hide');
                        var table = $('#emailListTable').DataTable();
                        table.ajax.reload();*/
                    },
                    error: function ($addNewTask_xhr, ajaxOptions, thrownError) {
                        // console.log('error');
                        // $error = JSON.parse($addNewTask_xhr.responseText);
                        // $.each($error.errors, function($i, $val) {
                        //     toastr.error($val);
                        // });
                    }
                });
            };

        </script>
    <body>
<html>

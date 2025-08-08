<div>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        .container-fluid {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card-custom {
            height: 95vh;
            width: calc(100% - 40px);
            margin: 20px auto;
            display: flex;
            flex-direction: column;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            overflow-y: auto;
            flex: 1;
            padding: 20px;
        }

        .left-section {
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #F5B029;
            color: white;
            padding: 20px;
        }

        .left-section p {
            text-align: justify;
        }

        .right-section {
            position: relative;
            flex: 1;
            overflow-y: auto;
            padding-left: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .progress-bar-custom {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
        }

        .btn-group-custom {
            display: flex;
            justify-content: center;
            margin-top: auto;
            padding: 20px;
        }

        .btn-group-custom button {
            margin: 0 5px;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .btn-group-custom button:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-group-custom button:nth-child(1) {
            background-color: #6c757d;
        }

        .btn-group-custom button:nth-child(1):hover {
            background-color: #495057;
        }

        .btn-group-custom button:nth-child(2) {
            background-color: #3f73a1;
        }

        .btn-group-custom button:nth-child(2):hover {
            background-color: #2c5884;
        }
        @media (min-width: 768px) {
            .card-body-custom {
                display: flex;
            }

            .left-section {
                max-width: 500px;
            }
        }

        .loader-container {
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 999;
        }

        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    <div class="container-fluid">
        <div class="card card-custom">
            <div class="card-body card-body-custom">
                <div class="left-section p-3 border-right">
                    <img src="{{ url('assets/img/logo-nido.png') }}" class="img-fluid" alt="Logo" style=" width: 30%;">
                    <h5>{{ $form->name }}</h5>
                    <p class="mt-3">{{ $form->description }}</p>
                </div>
                <div class="right-section p-3">
                    <div class="progress progress-bar-custom">
                        <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="loader-container" id="loader" style="display: none;">
                        <div class="loader"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 class="mt-4">Información de la empresa:</h4>
                        </div>
                        <div class="col-lg-12">
                            <form id="form-appointment" autocomplete="off">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="is-required">NIT / Cédula:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm" id="field1" name="field1">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="field2">Campo 2: <span style="color: red">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="field2" name="field2">
                                    </div>
                                </div>
                            
                                <div class="row mt-3">
                                    <div class="form-group col-md-6">
                                        <label for="field3">Campo 3: <span style="color: red">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="field3" name="field3">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="field4">Campo 4: <span style="color: red">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="field4" name="field4">
                                    </div>
                                </div>
                            
                                <div class="row mt-3">
                                    <div class="form-group col-md-6">
                                        <label for="field5">Campo 5: <span style="color: red">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="field5" name="field5">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="field6">Campo 6: <span style="color: red">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="field6" name="field6">
                                    </div>
                                </div>
                            
                                <div class="btn-group-custom mt-auto">
                                    <button class="btn btn-secondary mr-2" type="button">Cancel</button>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </form>                                                     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function simulateLoading() {
            document.getElementById("loader").style.display = "flex";
            setTimeout(function() {
                document.getElementById("loader").style.display = "none";
                document.getElementById("form-container").style.display = "block";
            }, 1000);
        }
    
        window.onload = simulateLoading;
    </script>
</div>

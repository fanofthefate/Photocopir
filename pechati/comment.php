
    <section class="back" id="con2" style="
    padding: 27px;
">

        <div id="fine-uploader-manual-trigger"></div>
        <div class="ta" style="
    padding-top: 20px;
">
        <span style="
    float: left;
    /* padding-left: 27px; */
">�����������</span><br>
            <textarea class="Order-info-comment"></textarea>
        </div>
        <div style="
    padding-top: 10px;
">
            <div style="
    padding: 3px 12px 4px 20px;
    /* height: 33px; */
    background-color: #C4017B;
    display: inline-block;
">
                <div style="
                display: inline-block;
    width: 80px;
    height: 22px;
    background-color: #fff;
"><span class="order_cost" style="
    width: 100px;
    height: 25px;
"></span></div>
                </span style="
                    padding-left: 10px
                ;
                    color: #fff
                ;
                ">���������<span></span></span></div>
            <form action="#" method="POST" onsubmit="return false;" style="
    float: right;
    display: inline-block;
">
                <button type="submit" id="getorder" name="get_order">������� � ���������� ������</button>
            </form>

        </div>
    </section>


    <!-- Fine Uploader New/Modern CSS file
    ====================================================================== -->
    <link href="css/fine-uploader-new.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">


    <!-- Fine Uploader Thumbnails template w/ customization
    ====================================================================== -->
    <script type="text/template" id="qq-template-manual-trigger">
        <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="���������� ���� ����� ����">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                     class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            <div class="buttons">
                <div class="qq-upload-button-selector qq-upload-button">
                    <div>������� �����...</div>
                </div>
            </div>
            <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing dropped files...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
            <ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
                <li>
                    <div class="qq-progress-bar-container-selector">
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                             class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <fieldset><img class="qq-thumbnail-selector" qq-max-size="100" qq-server-scale></fieldset>
                    <span class="qq-upload-file-selector qq-upload-file"></span><br>
                    <input class="recalculate file-count showhide" type="number" value="1" style="width: 35px;
    margin-left: -50px;
    position: absolute;">

                    <span class="qq-upload-size-selector qq-upload-size"></span>
                    <select class="recalculate file-format showhide" name="" id="" style="    position: absolute;">
                        <option value="�6">A6</option>
                        <option value="�5">A5</option>
                        <option value="�4">A4</option>
                        <option value="�3">A3</option>
                        <option value="�2">A2</option>
                        <option value="�1">A1</option>
                    </select>
                    <button type="button" class="qq-btn qq-upload-cancel-selector qq-upload-cancel">Cancel</button>
                    <button type="button" class="qq-btn qq-upload-retry-selector qq-upload-retry">Retry</button>
                    <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete" style="    position: absolute;
    margin-top: -141px;
    margin-left: 9px;">Delete
                    </button>
                    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                </li>
            </ul>
            <dialog class="qq-alert-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Close</button>
                </div>
            </dialog>

            <dialog class="qq-confirm-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">No</button>
                    <button type="button" class="qq-ok-button-selector">Yes</button>
                </div>
            </dialog>

            <dialog class="qq-prompt-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <input type="text">

                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cancel</button>
                    <button type="button" class="qq-ok-button-selector">Ok</button>
                </div>
            </dialog>
        </div>
    </script>

    <style>
        #trigger-upload {
            position: absolute;
            color: white;
            background-color: #419700;
            font-size: 14px;
            padding: 7px 20px;
            background-image: none;
            cursor: pointer;
        }

        #trigger-upload:hover {
            background: forestgreen;
        }

        #trigger-upload:focus {
            outline: 1px dotted #000000;
        }

        #fine-uploader-manual-trigger .qq-upload-button {
            margin-right: 15px;
        }

        #fine-uploader-manual-trigger .buttons {
            width: 36%;
        }

        #fine-uploader-manual-trigger .qq-uploader .qq-total-progress-bar-container {
            width: 60%;
        }
    </style>

    <!-- Fine Uploader DOM Element
    ====================================================================== -->
    <div id="fine-uploader-manual-trigger"></div>

    <!-- Your code to create an instance of Fine Uploader and bind to the DOM/template
    ====================================================================== -->
    <script>
        new qq.FineUploader({
            element: document.getElementById('fine-uploader-manual-trigger'),
            template: 'qq-template-manual-trigger',
            request: {
                endpoint: 'upload.php'
            },
            deleteFile: {
                enabled: true,
                forceConfirm: true,
                endpoint: 'delete.php?id='
            },
            callbacks: {
                onComplete: function (id, name, response) {
                    if($('#show_hide_added_files_options').length){
                        $('.showhide').show();
                    }else{
                        $('.showhide').remove();
                    }
                    var $container = $('.qq-file-id-'+id);
                    console.log(id, name, response);
                    if($container.find('.file-count')) {
                        $container.find('.file-count').val($('.Order-info-nu').val());
                        var R = $('.radio:checked').parent().attr('id');
                        var equal = {
                            'r1' : '�6',
                            'r2' : '�5',
                            'r3' : '�4',
                            'r4' : '�3',
                            'r5' : '�2',
                            'r6' : '�1'

                        };console.log($container.find('.file-format').val());
                        $container.find('.file-format').val(equal[R]);
                        // totalPrice(); commented
                        console.log($container.find('.file-format').val());
                    }
                },
                onDeleteComplete: function(id, xhr, isError) {
                    var $container = $('.qq-upload-success:last');
                    if($container.find('.file-count')) {
                        // totalPrice();
                    }
                }
            }

        });
    </script>


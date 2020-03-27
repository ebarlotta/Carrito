<?php
    <div class="alert alert-info alert-dimissible text-center" role="alert">
        <button type="button" class="close" data-dimiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        dd(session::get('message'));
        <h2><strong><i class="fa fa-info-circle"></i></strong> {{ session::get('message') }} </h2>
    </div>
?>
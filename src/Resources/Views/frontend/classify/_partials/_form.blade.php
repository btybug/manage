{!! Form::model($model,['url' => $url,'class' => 'form-horizontal','files' => true]) !!}
<fieldset>
    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" for="title">Title</label>
        <div class="col-md-4">
            {!! Form::text('title',null,['placeholder' => 'Enter Title', 'class' => 'form-control input-md vname']) !!}
        </div>
    </div>

    <!-- Textarea -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="description">Icon</label>
        <div class="col-md-4">
            {!! BBbutton('icons','icon','select icon',['model' => $model,'class' => 'form-control input-md vicon']) !!}
        </div>
    </div>

    <!-- Textarea -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="description">Image</label>
        <div class="col-md-4">
            {!! Form::file('image',['class' => 'form-control input-md']) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label" for="description">enable filter</label>
        <div class="col-md-4">
            {!! Form::hidden('filter',0) !!}
            {!! Form::checkbox('filter',1,null,['style' => 'position: initial;']) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label" for="description">Description</label>
        <div class="col-md-4">
            {!! Form::textarea('description',null,['placeholder' => 'Enter Title', 'class' => 'form-control input-md vdesc']) !!}
        </div>
    </div>

    <!-- Button -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="singlebutton"></label>
        <div class="col-md-4">
            {!! Form::submit('Save',['id' => 'save-tax-data','class' => 'btn btn-info']) !!}
        </div>
    </div>

</fieldset>
{!! Form::close() !!}

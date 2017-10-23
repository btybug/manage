{!! Form::model($model,['url' => $url,'class' => 'form-horizontal']) !!}
<fieldset>
{!! Form::hidden('classifier_id',($model) ? null : $classifier->id) !!}
<!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" for="title">Title</label>
        <div class="col-md-4">
            {!! Form::text('title',null,['placeholder' => 'Enter Title', 'class' => 'form-control input-md vname']) !!}
        </div>
    </div>

    <!-- Textarea -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="description">Description</label>
        <div class="col-md-4">
            {!! Form::textarea('description',null,['placeholder' => 'Enter Title', 'class' => 'form-control input-md vdesc']) !!}
        </div>
    </div>


    <!-- Textarea -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="description">Parent</label>
        <div class="col-md-4">
            {!! Form::select('parent_id',[null => 'No Parent'] + $items,null,['class' => 'form-control input-md']) !!}
        </div>
    </div>

    <!-- Textarea -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="description">Icon</label>
        <div class="col-md-4">
            {!! BBbutton('icons','icon','select icon',['model' => $model,'class' => 'form-control input-md vicon']) !!}
        </div>
    </div>

    <!-- Button -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="singlebutton"></label>
        <div class="col-md-4">
            {!! Form::submit('Save',['class' => 'btn btn-info']) !!}
        </div>
    </div>

</fieldset>
{!! Form::close() !!}

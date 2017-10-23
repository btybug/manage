{!! sc('getCoreForm',["id" =>4]) !!}
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading bg-black-darker text-white">Menu: Main Navigation</div>
            <div class="panel-body ">
                <div class="form-group col-md-4">
                    <label for="menuname">Menu Name</label>
                    {!! Form::text('title',null,['class'=>'form-control','placeholder'=>'Main Navigation']) !!} </div>
                <div class="form-group col-md-3">
                    <label for="type">Type</label>
                    {!! Form::select('type', [ 'horizontal' => 'Horizontal', 'vertical' => 'Vertical' ], null, ['id' => 'menuTypes', 'class' => 'form-control']) !!}
                </div>

                <div class="form-group col-md-3">
                    <label for="template">Menu Template</label>
                    {!! Form::select('template', [ 'default' => 'Default' ], null, ['id' => 'template', 'class' => 'form-control']) !!}
                </div>
                <div class="form-group col-md-2">
                    {!! Form::submit('Save Menu', array('class' => 'btn btn-success')) !!}
                </div>

            </div>
        </div>
    </div>
</div>

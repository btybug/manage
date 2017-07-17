<div class="row toolbarNav m-b-10 p-b-5">
    <div class="col-md-9">
        <div class="form-inline">
            <div class="form-group p-r-10 p-b-5  m-0">
                <label for="name" class="p-r-10">Name</label>
                {!! Form::text('title',null,['class' => 'form-control','id' => 'tax_title']) !!}
                {!! Form::hidden('description',null,['id' => 'tax_description']) !!}
                {!! Form::hidden('image',null,['id' => 'tax_image']) !!}
                {!! Form::hidden('icon',null,['id' => 'tax_icon']) !!}
                <a href="javascript:void(0)" class="btn btn-ls edit-taxonomy"><i class="fa fa-edit"></i></a>
            </div>
        </div>
    </div>
    <div class="col-md-3 text-right">
        {!! Form::submit('Save Taxonomy', array('class' => 'btn btn-danger btn-danger-red', 'data-save' => 'taxonomy' )) !!}
    </div>
</div>

<div class="row">
    <div class="col-md-4 menu_childs">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading bg-black-darker text-white">Create Terms
                    <a href="javascript:void(0)" class="btn btn-md add-term"><i class="fa fa-plus"></i></a></div>
                <div class="panel-body">

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading bg-black-darker text-white">
                Edit place
            </div>
            <div class="panel-body panel-virtual">

            </div>
        </div>
    </div>
</div>
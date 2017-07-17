<li data-parent="{{ $model['parent_id'] }}" data-item="{{ $model['id'] }}">

    <div class="drag-handle not-selected">
        <i class="{!! @$model['icon'] !!}" bb-icon="{{ $model['id'] }}" aria-hidden="true"></i>
        <span class="title-area-{{ $model['id'] }}">{{ $model['title'] }}</span>

        <button type="button" class="edit-term btn btn-primary btn-sm pull-right " data-count="{{ $model['id'] }}"
                data-title="{{ $model['title'] }}" data-desc="{{ $model['description'] }}"><i class="fa fa-edit"></i>
        </button>
        <button type="button" class="delete-term btn btn-danger btn-sm  pull-right m-r-5"><i class="fa fa-trash"></i>
        </button>

    </div>

    {!! Form::hidden('terms[edit]['.$model['id'].'][id]',@$model['id']) !!}
    {!! Form::hidden('terms[edit]['.$model['id'].'][title]',@$model['title'],['class' => 'title_'.$model['id']]) !!}
    {!! Form::hidden('terms[edit]['.$model['id'].'][description]',@$model['description'],['class' => 'description_'.$model['id']]) !!}
    {!! Form::hidden('terms[edit]['.$model['id'].'][icon]',@$model['icon'],['class' => 'icon_'.$model['id']]) !!}
    {!! Form::hidden('terms[edit]['.$model['id'].'][parent_id]',@$model['parent_id'],['class' => 'icon_parent_'.$model['id']]) !!}
</li>
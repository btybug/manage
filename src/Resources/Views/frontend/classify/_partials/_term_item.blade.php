<li data-parent="{{ $model['parent_id'] or 0 }}" data-item="{{ @$model['count'] }}">
    <div class="drag-handle not-selected">
        <i class="{!! @$model['icon'] !!}" bb-icon="{{ @$model['count'] }}" aria-hidden="true"></i> <span
                class="title-area-{{ @$model['count'] }}"> {{ $model['title'] }}</span>
        <button type="button" class="edit-term btn btn-primary btn-sm pull-right" data-count="{{ @$model['count'] }}"
                data-title="{{ $model['title'] }}" data-desc="{{ $model['description'] }}"><i class="fa fa-edit"></i>
        </button>
        <button type="button" class="delete-term btn btn-danger btn-sm  pull-right m-r-5"><i class="fa fa-trash"></i>
        </button>

    </div>
    {!! Form::hidden('terms[new]['.@$model['count'].'][title]',@$model['title'],['class' => 'title_'.@$model['count']]) !!}
    {!! Form::hidden('terms[new]['.@$model['count'].'][description]',@$model['description'],['class' => 'description_'.@$model['count']]) !!}
    {!! Form::hidden('terms[new]['.@$model['count'].'][icon]',@$model['icon'],['class' => 'icon_'.@$model['count']]) !!}
    {!! Form::hidden('terms[new]['.@$model['count'].'][parent_id]',@$model['parent_id'] or 0,['class' => 'icon_parent_'.@$model['count']]) !!}
</li>
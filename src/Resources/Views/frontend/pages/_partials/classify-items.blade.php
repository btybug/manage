<div class="col-md-12 m-t-15 data-cl" data-cl="{!! $classify->id !!}">
    <div class="col-md-4">
        <ul>
            <li class="panel panel-default page_col">
                <div class="panel-heading" style="background-color: black;color:white;" role="tab">
                    <h4 class="panel-title">
                        <div data-id="{{ $classify->id }}" class="delete-classify">
                            <i class="fa fa-ban">&nbsp;</i>
                        </div>
                        <a href="javascript:void(0)" aria-expanded="true" class="link_name">
                            {{ $classify->title }}
                        </a>
                    </h4>
                </div>
            </li>
        </ul>
    </div>
    <div class="col-md-6 pull-right">
        <label>Select {!! str_plural($classify->title) !!}
            @if(($type && $type == 'multiple') || (isset($classifyRelation) && $classifyRelation->isMultiple()))
                {!! Form::select('classify['. $classify->id . '][]' ,$termsList,$classifyRelation->getClassifierItemsByClassifier(),["class" => "form-control classify-options", 'multiple' => 'multiple']) !!}
            @else
                {!! Form::select('classify['. $classify->id . ']' ,[''=>"--Select--"] + $termsList,isset($classifyRelation) ? $classifyRelation->classifierItem()->first()->id : null,["class" => "form-control classify-options"]) !!}
            @endif
        </label>
    </div>
</div>
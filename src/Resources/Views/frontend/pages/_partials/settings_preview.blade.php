<div class="panel panel-default custompanel m-t-20">
    <div class="panel-heading">
        Select Page Layout Placeholders
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12 layout-data">
                <div id="placeholders">
                    @if($model && isset($model->placeholders))
                        @foreach($model->placeholders as $key=>$placeholder)
                            <div class="col-md-12">
                                @if(isset($placeholder['tag']))
                                    {!! BBbutton2('unit',$key,$placeholder['tag'],(isset($placeholder['title'])?$placeholder['title']:'Sidebar'),
                                    ['class'=>'btn btn-default change-layout','data-type'=>$placeholder['tag'],
                                    'data-name-prefix'=>'page_layout_settings',
                                    'model'=>($settings[$key])??null]) !!}
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
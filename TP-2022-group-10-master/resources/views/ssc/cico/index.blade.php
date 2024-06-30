{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_ssc')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('ssc/cico/index.title_html'))
@section('page_title', __('ssc/cico/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('ssc/cico/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('ssc/cico/index.breadcrumb_level_2') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')
    @foreach($check as $c)
{{--        {{$c->location['coords']['longitude']}}, {{$c->location['coords']['latitude']}}--}}
    @endforeach

    <div id="map" style="width: 100%; height: 400px;"></div>
    <div id="popup" class="ol-popup">
        <a href="#" id="popup-closer" class="ol-popup-closer"></a>
        <div id="popup-content"></div>
    </div>


    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info"
                   data-turbolinks="false">
                <thead>
                <tr role="row">
                    <th>{{ __('ssc/cico/index.th_datetime') }}</th>
                    <th>{{ __('ssc/cico/index.th_employee_id') }}</th>
                    <th>{{ __('ssc/cico/index.th_employee') }}</th>
                    <th>{{ __('ssc/cico/index.th_site') }}</th>
                    <th>{{ __('ssc/cico/index.th_type') }}</th>
                    <th>{{ __('ssc/cico/index.th_location') }}</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{ __('ssc/cico/index.th_datetime') }}</th>
                    <th>{{ __('ssc/cico/index.th_employee_id') }}</th>
                    <th>{{ __('ssc/cico/index.th_employee') }}</th>
                    <th>{{ __('ssc/cico/index.th_site') }}</th>
                    <th>{{ __('ssc/cico/index.th_type') }}</th>
                    <th>{{ __('ssc/cico/index.th_location') }}</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($check as $c)
                    <tr>
                        <td>
                            {{ $c->created_at }}
                        </td>
                        <td>
                            {{ $c->employee->employee_id }}
                        </td>
                        <td>
                            {{ $c->employee->first_name }} {{ $c->employee->last_name }}
                        </td>
                        <td>
                            {{ $c->site_id }}
                        </td>
                        <td>
                            {{ $c->type }}
                        </td>
                        <td>
                            <pre>{{ json_encode($c->location??[],JSON_PRETTY_PRINT) }}</pre>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')
    @include('ssc.cico.index.script_table')

    <script type="text/javascript">
        var attribution = new ol.control.Attribution({
            collapsible: false
        });

        var map = new ol.Map({
            controls: ol.control.defaults({attribution: false}).extend([attribution]),
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM({
                        url: 'https://tile.openstreetmap.org/{z}/{x}/{y}.png	',
                        attributions: [ ol.source.OSM.ATTRIBUTION, 'Tiles courtesy of <a href="https://geo6.be/">GEO-6</a>' ],
                        maxZoom: 18
                    })
                })
            ],
            target: 'map',
            view: new ol.View({
                center: ol.proj.fromLonLat([114.173295, 22.2833808]),
                maxZoom: 18,
                zoom: 12
            })
        });

        var layer = new ol.layer.Vector({
            source: new ol.source.Vector({
                features: [
                    @foreach($check as $c)
                    new ol.Feature({
                        geometry: new ol.geom.Point(ol.proj.fromLonLat([
                            {{ $c->location['coords']['longitude'] }},
                            {{ $c->location['coords']['latitude'] }},
                        ]))
                    }),
                    @endforeach
                ]
            })
        });
        map.addLayer(layer);

        var container = document.getElementById('popup');
        var content = document.getElementById('popup-content');
        var closer = document.getElementById('popup-closer');
        var overlay = new ol.Overlay({
            element: container,
            autoPan: true,
            autoPanAnimation: {
                duration: 250
            }
        });
        map.addOverlay(overlay);
        closer.onclick = function() {
            overlay.setPosition(undefined);
            closer.blur();
            return false;
        };

        map.on('singleclick', function (event) {
            if (map.hasFeatureAtPixel(event.pixel) === true) {
                var coordinate = event.coordinate;
                content.innerHTML = '<div style="background-color: white;">Hello world!<br />I am a popup.</div>';
                overlay.setPosition(coordinate);
            } else {
                overlay.setPosition(undefined);
                closer.blur();
            }
        });
    </script>
@endpush

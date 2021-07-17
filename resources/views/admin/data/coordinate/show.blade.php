@extends('admin.layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Data Coordinate') }}
    </h2>
@endsection

@section('card-title')
    Data Coordinate
@endsection

@section('content')
    @foreach ($data as $data)
        ID = {{ $data->id }} <br>
        ID Operator = {{ $data->id_operator }}<br>
        Range = {{ $data->range }}<br>
        Tower Name = {{ $data->name }}<br>
        Serial Number = {{ $data->serial }}<br>
        Latitude = {{ $data->latitude }}<br>
        Longitude = {{ $data->longitude }}<br>
    @endforeach
    <div style="width: 100%" id="map" class="map"></div>
    @push('scripts')
        <script type="text/javascript">
            var sites = {!! json_encode($data) !!};
            console.log(sites);
            var map = new ol.Map({
                target: 'map',
                layers: [
                    new ol.layer.Tile({
                        source: new ol.source.XYZ({
                            url: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
                            maxZoom: 17
                        })
                    })
                ],
                view: new ol.View({
                    center: ol.proj.fromLonLat([sites['longitude'], sites['latitude']]),
                    zoom: 17
                })
            });
            var layer = new ol.layer.Vector({
                source: new ol.source.Vector({
                    features: [
                        new ol.Feature({
                            geometry: new ol.geom.Point(ol.proj.fromLonLat([sites['longitude'], sites[
                                'latitude']]))
                        })
                    ]
                })
            });
            map.addLayer(layer);

            // var sites = @json($data);
            // console.log(sites['name']);
        </script>
    @endpush
@endsection

<x-dynamic-component :component="$getFieldWrapperView()" :id="$getId()" :label="$getLabel()" :label-sr-only="$isLabelHidden()" :helper-text="$getHelperText()"
    :hint="$getHint()" :hint-action="$getHintAction()" :hint-color="$getHintColor()" :hint-icon="$getHintIcon()" :required="$isRequired()" :state-path="$getStatePath()">
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
    <div wire:key="{{ rand() }}" x-data="map(@entangle($getStatePath()).defer)">
        <section id="map"></section>
    </div>
</x-dynamic-component>
<script src="{{ asset('dist/' . ViteManifest::make()->run('src/js/map.ts')) }}"></script>

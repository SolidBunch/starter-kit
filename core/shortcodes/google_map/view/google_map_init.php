var geocoder = new google.maps.Geocoder();

var latlong;

var styles = [
{
stylers: [
{hue: '<?php echo $data['atts']['hue']; ?>' },
{saturation: <?php echo $data['atts']['saturation']; ?>},
{lightness: <?php echo $data['atts']['lightness']; ?>},
{gamma: <?php echo $data['atts']['gamma']; ?>}
]
}
];

var googleMapOptions = {
zoom: <?php echo absint( $data['atts']['zoom'] ); ?>,
center: new google.maps.LatLng(0, 0),
mapTypeId: google.maps.MapTypeId.roadmap,
panControl: false,
zoomControl: true,
scrollwheel: false,
disableDoubleClickZoom: true,
disableDefaultUI: true,
draggable: true,
scaleControl: true,
styles: styles
};

setTimeout( function() {

var map = new google.maps.Map(document.getElementById('google-map-id-<?php echo $data['atts']['el_id']; ?>'), googleMapOptions);

geocoder.geocode({'address': '<?php echo esc_html( $data['atts']['address'] ); ?>'}, function (results, status) {
if (status == google.maps.GeocoderStatus.OK) {
latlong = results[0].geometry.location;

var marker = new google.maps.Marker({
position: latlong,
map: map<?php if ( $data['atts']['pin_icon'] <> '' ): ?>,
	icon: '<?php echo wp_get_attachment_url( $data['atts']['pin_icon'] ) ?>'<?php endif; ?>
});

map.setCenter(latlong);

map.panBy( <?php echo $data['atts']['pin_offset_x']; ?>, <?php echo $data['atts']['pin_offset_y']; ?>);
	
}
});

}, 1000);

/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../website/css/bootstrap.min.css');
require('../website/scss/app.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');
import Swal from 'sweetalert2';
 const routes = require('../../public/js/fos_js_routes.json');
 import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min';


Routing.setRoutingData(routes);
// console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
// $(".saveButton").click((e)=> {
$('.saveButton').each(function () {

    $(this).on("click", function () {
    Swal.fire({
        title: 'Is this profile really for you ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
    })
        .then((result) => {
            // var author = $(".saveProfile").data("author");
            var author= $(this).data('author')
            console.log("author")
            console.log(author)


            var url = Routing.generate('get_author_allpublication_profile', {
                'auteur': author
            });
            if (result.value) {
                window.location = url;
                console.log(url)
            }
        })
    });
});
// });
// $('.saveButton').each(function () {
//
//     $(this).on("click", function () {
//         console.log($(this).data('author'));
//     });
// });

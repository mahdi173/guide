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

$('.deletePublication').each(function () {

    $(this).on("click", function () {
        Swal.fire({
            title: 'You want to delete this publication ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        })
            .then((result) => {
                // var author = $(".saveProfile").data("author");
                var publication= $(this).data('publication')
                console.log("publication")
                console.log(publication)


                var url = Routing.generate('all_publication_delete', {
                    'id': publication
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

$('#modal_edit').on('show.bs.modal', function (event) {
    console.log('rr')
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id= button.data('publication') // Extract info from data-* attributes

    var modal = $(this)
    var id0=id[0]


    console.log($('#all_publication_title'))
    var id=id0['id'];
    var title=id0['title'];
    var type=id0['type'];
    var name=id0['name'];
    var volume=id0['volume'];
    var year=id0['year'];
    var url=id0['url'];
    console.log('id')
    console.log(id)

    // $('#all_publication_title').val(title)
    var t=document.getElementById('all_publication_title');
    t.value=id0['title']
    $('#all_publication_type').val(type)
    $('#all_publication_name').val(name)
    $('#all_publication_volume').val(volume)
    $('#all_publication_year').val(year)
    $('#all_publication_url').val(url)
    $('#all_publication_idPublication').val(id)



//     modal.find('#all_publication_title').val(title)
//     modal.find('.modal-body input').val(id)
})

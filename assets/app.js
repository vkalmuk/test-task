/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';
import $ from 'jquery';

$(function (){
    let $colletion = $('.collection');

    $colletion.on('click', '.remove-row', function(e) {
        e.preventDefault();
        $(this)
            .closest('.collection-row')
            .remove()
        ;
    });

    $colletion.on('click', '.add-row', function(e) {
        e.preventDefault();
        let $rowWrapper = $(this).closest('.collection').find('.row-wrapper');
        let prototype = $rowWrapper.data('prototype');
        let index = $rowWrapper.data('index');
        let newRow = prototype.replace(/__name__/g, index);
        $rowWrapper.data('index', index + 1);
        $rowWrapper.append(newRow);
    });
});
import Quill from 'quill';
import 'quill-emoji';
const toolbarOptions = {
    container: [
        // ['bold', 'italic', 'underline', 'strike'],
        ['emoji'],
    ],
    handlers: {'emoji': function() {}}
}


var options = {
    placeholder: 'Please write your review here',
    modules: {
        syntax: false,
        toolbar: toolbarOptions,
        "emoji-toolbar": true,
        "emoji-textarea": true,
        "emoji-shortname": true,
    },
    theme: 'snow'
};

var editor = new Quill('#editor', options);

// require('./bootstrap');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const algoliasearch = require("algoliasearch");
const client = algoliasearch('W5EBAI9HL0', '4a03ef133228ab702888273938b85f40');
const index = client.initIndex('MALAYSIAlp_index');
import autocomplete from './autocomplete.min';

function newHitsSource(index, params) {
    return function doSearch(query, cb) {
        index
            .search(query, params)
            .then(function(res) {
                cb(res.hits, res);
            })
            .catch(function(err) {
                console.error(err);
                cb([]);
            });
    };
}

autocomplete('#searchbox', {  }, [
    {
        source: newHitsSource(index, { hitsPerPage: 5 }),
        templates: {
            suggestion: function(suggestion) {
                return '<a href="https://my.wuchna.com/'+suggestion.city+'/'+suggestion.slug+'"><span>'+suggestion._highlightResult.slug.value.replace(/-/g,' ')+'</span></a>';
            }
        }
    }
]).on('autocomplete:selected', function(event, suggestion, dataset, context) {
    window.location.href = 'https://my.wuchna.com/'+suggestion.city+'/'+suggestion.slug;
});

import Vue from 'vue';
window.Vue = Vue;




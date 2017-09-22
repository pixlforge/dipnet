import autocomplete from 'autocomplete.js';
import algolia from 'algoliasearch';

let index = algolia('56EGLJ6XUN', 'c22b4751399f17ed81411a3b52255335');

export const orderautocomplete = (selector) => {
    index = index.initIndex('orders');

    return autocomplete(selector, {
        hint: true
    }, {
        source: autocomplete.sources.hits(index, { hitsPerPage: 10 }),
        displayKey: 'reference',
        templates: {
            suggestion(suggestion) {
                return `
                            <span>${suggestion._highlightResult.reference.value}</span>
                        `
            },
            empty: '<div class="aa-empty">Aucun résultat</div>'
        }
    });
}
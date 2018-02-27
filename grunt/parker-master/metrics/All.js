/*! Parker v0.0.0 - MIT license */

'use strict';

module.exports = [
    // Stylesheet Totals
    require('./TotalStylesheets.js'),
    require('./TotalStylesheetSize.js'),

    // Stylesheet Element Totals
    require('./TotalRules.js'),
    require('./TotalSelectors.js'),
    require('./TotalIdentifiers.js'),
    require('./TotalDeclarations.js'),

    // Stylesheet Element Averages
    require('./SelectorsPerRule.js'),
    require('./IdentifiersPerSelector.js'),
    require('./DeclarationsPerRule.js'),

    // Specificity
    require('./SpecificityPerSelector.js'),
    require('./PreciseSpecificityPerSelector.js'),
    require('./TopSelectorSpecificity.js'),
    require('./PreciseTopSelectorSpecificity.js'),
    require('./StringTopSelectorSpecificity.js'),
    require('./TopSelectorSpecificitySelector.js'),
    require('./TotalIdSelectors.js'),

    // Colour
    require('./TotalUniqueColours.js'),
    require('./UniqueColours.js'),

    // Important Keywords
    require('./TotalImportantKeywords.js'),

    // Media Queries
    require('./TotalMediaQueries.js'),
    require('./MediaQueries.js'),

    // Z-Index
    require('./ZIndexes.js')
];
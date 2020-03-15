/*
 * This file belong to app.utp.pt
 *
 * Copyright (c) 2019 Creative Code Solutions <creativecodesolutions.pt>. File Translation.js is protected by
 * All Rights Reserved
 */

const _ = require('lodash');

let trans = (string, args) => {
    let value = _.get(window.translations, string);

    _.eachRight(args, (paramVal, paramKey) => {
        value = _.replace(value, `:${paramKey}`, paramVal);
    });
    return value;
};

module.exports = trans;

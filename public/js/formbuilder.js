"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["/js/formbuilder"],{

/***/ "./resources/assets/js/scripts/DynamicField.ts":
/*!*****************************************************!*\
  !*** ./resources/assets/js/scripts/DynamicField.ts ***!
  \*****************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {



var __importDefault = this && this.__importDefault || function (mod) {
  return mod && mod.__esModule ? mod : {
    "default": mod
  };
};

Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports.DynamicField = void 0;

var jquery_1 = __importDefault(__webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js"));

__webpack_require__(/*! select2 */ "./node_modules/select2/dist/js/select2.js");

var DynamicField =
/** @class */
function () {
  function DynamicField() {}
  /**
   * Hide and Show different form fields based on vocabulary and other types
   */


  DynamicField.prototype.hideShowFormFields = function () {
    this.humanitarianScopeHideVocabularyUri();
    this.countryBudgetHideCodeField();
    this.aidTypeVocabularyHideField();
    this.sectorVocabularyHideField();
    this.policyVocabularyHideField();
    this.recipientVocabularyHideField();
    this.sectorVocabularyHideField();
    this.tagVocabularyHideField();
    this.transactionAidTypeVocabularyHideField();
    this.indicatorReferenceHideFieldUri();
  };
  /**
   * Humanitarian Scope Form Page
   *
   * @Logic hide vocabulary-uri field based on '@vocabulary' field value
   */


  DynamicField.prototype.humanitarianScopeHideVocabularyUri = function () {
    var _this = this;

    var humanitarianScopeVocabulary = (0, jquery_1["default"])('select[id^="humanitarian_scope"][id*="[vocabulary]"]');

    if (humanitarianScopeVocabulary.length > 0) {
      // hide fields on page load
      jquery_1["default"].each(humanitarianScopeVocabulary, function (index, scope) {
        var _a;

        var val = (_a = (0, jquery_1["default"])(scope).val()) !== null && _a !== void 0 ? _a : '';

        _this.hideHumanitarianScopeField((0, jquery_1["default"])(scope), val.toString());
      }); // hide/show fields on value change

      humanitarianScopeVocabulary.on('select2:select', function (e) {
        var val = e.params.data.id;
        var index = e.target;

        _this.hideHumanitarianScopeField((0, jquery_1["default"])(index), val);
      }); // hide/show fields on value clear

      humanitarianScopeVocabulary.on('select2:clear', function (e) {
        var index = e.target;

        _this.hideHumanitarianScopeField((0, jquery_1["default"])(index), '');
      });
    }
  }; // hide country budget based on vocabulary


  DynamicField.prototype.hideHumanitarianScopeField = function (index, value) {
    var humanitarianScopeHideVocabularyUri = 'input[id^="humanitarian_scope"][id*="[vocabulary_uri]"]';

    if (value === '99') {
      index.closest('.form-field-group').find(humanitarianScopeHideVocabularyUri).show().removeAttr('disabled').closest('.form-field').show();
    } else {
      index.closest('.form-field-group').find(humanitarianScopeHideVocabularyUri).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
    }
  };
  /**
  * Humanitarian Scope Form Page
  *
  * @Logic hide vocabulary-uri field based on '@vocabulary' field value
  */


  DynamicField.prototype.indicatorReferenceHideFieldUri = function () {
    var _this = this;

    var referenceVocabulary = (0, jquery_1["default"])('select[id^="reference"][id*="[vocabulary]"]');

    if (referenceVocabulary.length > 0) {
      // hide fields on page load
      jquery_1["default"].each(referenceVocabulary, function (index, scope) {
        var _a;

        var val = (_a = (0, jquery_1["default"])(scope).val()) !== null && _a !== void 0 ? _a : '';

        _this.indicatorReferenceHideField((0, jquery_1["default"])(scope), val.toString());
      }); // hide/show fields on value change

      referenceVocabulary.on('select2:select', function (e) {
        var val = e.params.data.id;
        var index = e.target;

        _this.indicatorReferenceHideField((0, jquery_1["default"])(index), val);
      }); // hide/show fields on value clear

      referenceVocabulary.on('select2:clear', function (e) {
        var index = e.target;

        _this.indicatorReferenceHideField((0, jquery_1["default"])(index), '');
      });
    }
  }; // hide country budget based on vocabulary


  DynamicField.prototype.indicatorReferenceHideField = function (index, value) {
    var referenceUri = 'input[id^="reference"][id*="[indicator_uri]"]';

    if (value === '99') {
      index.closest('.form-field-group').find(referenceUri).show().removeAttr('disabled').closest('.form-field').show();
    } else {
      index.closest('.form-field-group').find(referenceUri).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
    }
  };
  /**
   * Country Budget Form Page
   *
   * @Logic show/hide 'code' field based on '@vocabulary' field value
   */


  DynamicField.prototype.countryBudgetHideCodeField = function () {
    var _this = this;

    var _a;

    var countryBudgetVocabulary = (0, jquery_1["default"])('select#country_budget_vocabulary');

    if (countryBudgetVocabulary.length > 0) {
      // hide/show on page load
      var val = (_a = countryBudgetVocabulary.val()) !== null && _a !== void 0 ? _a : '1';
      this.hideCountryBudgetField(val.toString()); // hide/show on value change

      countryBudgetVocabulary.on('select2:select', function (e) {
        var val = e.params.data.id;

        _this.hideCountryBudgetField(val);
      }); //hide/show based on value cleared

      countryBudgetVocabulary.on('select2:clear', function () {
        _this.hideCountryBudgetField('');
      });
    }
  };
  /**
   * Hide Country Budget Fields
   */


  DynamicField.prototype.hideCountryBudgetField = function (value) {
    var countryBudgetCodeInput = 'input[id^="budget_item"][id*="[code_text]"]',
        countryBudgetCodeSelect = 'select[id^="budget_item"][id*="[code]"]';

    if (value === '1') {
      (0, jquery_1["default"])(countryBudgetCodeSelect).val('').trigger('change').attr('disabled', 'disabled').closest('.form-field').hide();
      (0, jquery_1["default"])(countryBudgetCodeInput).removeAttr('disabled').closest('.form-field').show();
    } else {
      (0, jquery_1["default"])(countryBudgetCodeSelect).removeAttr('disabled').closest('.form-field').show();
      (0, jquery_1["default"])(countryBudgetCodeInput).val('').trigger('change').closest('.form-field').hide();
    }
  };
  /**
   * AidType Form Page
   *
   * @Logic hide vocabulary-uri and codes field based on '@vocabulary' field value
   */


  DynamicField.prototype.aidTypeVocabularyHideField = function () {
    var _this = this;

    var aidtype_vocabulary = (0, jquery_1["default"])('select[id*="default_aid_type_vocabulary"]');

    if (aidtype_vocabulary.length > 0) {
      jquery_1["default"].each(aidtype_vocabulary, function (index, item) {
        var _a;

        var data = (_a = (0, jquery_1["default"])(item).val()) !== null && _a !== void 0 ? _a : '1';

        _this.hideAidTypeSelectField((0, jquery_1["default"])(item), data.toString());
      });
      aidtype_vocabulary.on('select2:select', function (e) {
        var data = e.params.data.id;
        var target = e.target;

        _this.hideAidTypeSelectField((0, jquery_1["default"])(target), data);
      });
      aidtype_vocabulary.on('select2:clear', function (e) {
        var target = e.target;

        _this.hideAidTypeSelectField((0, jquery_1["default"])(target), '');
      });
    }
  };
  /**
   * AidType Form Page
   *
   * @Logic hide vocabulary-uri and codes field based on '@vocabulary' field value
   */


  DynamicField.prototype.transactionAidTypeVocabularyHideField = function () {
    var _this = this;

    var aidtype_vocabulary = (0, jquery_1["default"])('select[id*="aid_type_vocabulary"]');

    if (aidtype_vocabulary.length > 0) {
      jquery_1["default"].each(aidtype_vocabulary, function (index, item) {
        var _a;

        var data = (_a = (0, jquery_1["default"])(item).val()) !== null && _a !== void 0 ? _a : '1';

        _this.hideTransactionAidTypeSelectField((0, jquery_1["default"])(item), data.toString());
      });
      aidtype_vocabulary.on('select2:select', function (e) {
        var data = e.params.data.id;
        var target = e.target;

        _this.hideTransactionAidTypeSelectField((0, jquery_1["default"])(target), data);
      });
      aidtype_vocabulary.on('select2:clear', function (e) {
        var target = e.target;

        _this.hideTransactionAidTypeSelectField((0, jquery_1["default"])(target), '');
      });
    }
  };
  /**
   * Hide Aid Type Select Fields
   */


  DynamicField.prototype.hideAidTypeSelectField = function (index, value) {
    var default_aid_type = 'select[id*="[default_aid_type]"]',
        earmarking_category = 'select[id*="[earmarking_category]"]',
        earmarking_modality = 'select[id*="[earmarking_modality]"]',
        cash_and_voucher_modalities = 'select[id*="[cash_and_voucher_modalities]"]',
        case1 = 'select[id*="[earmarking_category]"],select[id*="[earmarking_modality]"],select[id*="[cash_and_voucher_modalities]"]',
        case2 = 'select[id*="[default_aid_type]"],select[id*="[earmarking_modality]"],select[id*="[cash_and_voucher_modalities]"]',
        case3 = 'select[id*="[default_aid_type]"],select[id*="[earmarking_category]"],select[id*="[cash_and_voucher_modalities]"]',
        case4 = 'select[id*="[default_aid_type]"],select[id*="[earmarking_category]"],select[id*="[earmarking_modality]"]';

    switch (value) {
      case '2':
        index.closest('.form-field-group').find(earmarking_category).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case2).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
        break;

      case '3':
        index.closest('.form-field-group').find(earmarking_modality).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case3).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
        break;

      case '4':
        index.closest('.form-field-group').find(cash_and_voucher_modalities).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case4).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
        break;

      default:
        index.closest('.form-field-group').find(default_aid_type).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case1).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
    }
  };
  /**
   * Hide Transaction Aid Type Select Fields
   */


  DynamicField.prototype.hideTransactionAidTypeSelectField = function (index, value) {
    var aid_type = 'select[id*="[aid_type_code]"]',
        earmarking_category = 'select[id*="[earmarking_category]"]',
        earmarking_modality = 'select[id*="[earmarking_modality]"]',
        cash_and_voucher_modalities = 'select[id*="[cash_and_voucher_modalities]"]',
        case1 = 'select[id*="[earmarking_category]"],select[id*="[earmarking_modality]"],select[id*="[cash_and_voucher_modalities]"]',
        case2 = 'select[id*="[aid_type_code]"],select[id*="[earmarking_modality]"],select[id*="[cash_and_voucher_modalities]"]',
        case3 = 'select[id*="[aid_type_code]"],select[id*="[earmarking_category]"],select[id*="[cash_and_voucher_modalities]"]',
        case4 = 'select[id*="[aid_type_code]"],select[id*="[earmarking_category]"],select[id*="[earmarking_modality]"]';

    switch (value) {
      case '2':
        index.closest('.form-field-group').find(earmarking_category).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case2).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
        break;

      case '3':
        index.closest('.form-field-group').find(earmarking_modality).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case3).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
        break;

      case '4':
        index.closest('.form-field-group').find(cash_and_voucher_modalities).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case4).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
        break;

      default:
        index.closest('.form-field-group').find(aid_type).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case1).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
    }
  };
  /**
   * Policy Marker Form Page
   *
   * @Logic hide vocabulary-uri and codes field based on '@vocabulary' field value
   */


  DynamicField.prototype.policyVocabularyHideField = function () {
    var _this = this;

    var policymaker_vocabulary = (0, jquery_1["default"])('select[id*="policy_marker_vocabulary"]');

    if (policymaker_vocabulary.length > 0) {
      jquery_1["default"].each(policymaker_vocabulary, function (index, policy_marker) {
        var _a;

        var data = (_a = (0, jquery_1["default"])(policy_marker).val()) !== null && _a !== void 0 ? _a : '1';

        _this.hidePolicyMakerField((0, jquery_1["default"])(policy_marker), data.toString());
      });
      policymaker_vocabulary.on('select2:select', function (e) {
        var data = e.params.data.id;
        var target = e.target;

        _this.hidePolicyMakerField((0, jquery_1["default"])(target), data);
      });
      policymaker_vocabulary.on('select2:clear', function (e) {
        var target = e.target;

        _this.hidePolicyMakerField((0, jquery_1["default"])(target), '1');
      });
    }
  };
  /**
   * Hides Policy Marker Form Fields
   */


  DynamicField.prototype.hidePolicyMakerField = function (index, value) {
    var case1_show = 'select[id*="[policy_marker]"]',
        case2_show = 'input[id*="[policy_marker_text]"],input[id*="[vocabulary_uri]"]',
        case1 = 'input[id*="[policy_marker_text]"],input[id*="[vocabulary_uri]"]',
        case2 = 'select[id*="[policy_marker]"]';

    switch (value) {
      case '1':
        index.closest('.form-field-group').find(case1_show).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case1).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
        break;

      case '99':
        index.closest('.form-field-group').find(case2_show).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case2).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
        break;

      default:
        index.closest('.form-field-group').find(case1_show).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case1).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
    }
  };
  /**
   * Sector Form Page
   *
   * @Logic hide vocabulary-uri and codes field based on '@vocabulary' field value
   */


  DynamicField.prototype.sectorVocabularyHideField = function () {
    var _this = this;

    var sector_vocabulary = (0, jquery_1["default"])('select[id*="sector_vocabulary"]');

    if (sector_vocabulary.length > 0) {
      jquery_1["default"].each(sector_vocabulary, function (index, sector) {
        var _a;

        var data = (_a = (0, jquery_1["default"])(sector).val()) !== null && _a !== void 0 ? _a : '1';

        _this.hideSectorField((0, jquery_1["default"])(sector), data.toString());
      });
      sector_vocabulary.on('select2:select', function (e) {
        var data = e.params.data.id;
        var target = e.target;

        _this.hideSectorField((0, jquery_1["default"])(target), data);
      });
      sector_vocabulary.on('select2:clear', function (e) {
        var target = e.target;

        _this.hideSectorField((0, jquery_1["default"])(target), '1');
      });
    }
  };
  /**
   * Hide Sector Form fields
   */


  DynamicField.prototype.hideSectorField = function (index, value) {
    var case1_show = 'select[id*="[code]"]',
        case2_show = 'select[id*="[category_code]"]',
        case7_show = 'select[id*="[sdg_goal]"]',
        case8_show = 'select[id*="[sdg_target]"]',
        case98_99_show = 'input[id*="[text]"],input[id*="[vocabulary_uri]"]',
        default_show = 'input[id*="[text]"]',
        case1 = 'select[id*="[category_code]"],select[id*="[sdg_goal]"],select[id*="[sdg_target]"],input[id*="[vocabulary_uri]"],input[id*="[text]"]',
        case2 = 'input[id*="[vocabulary_uri]"],select[id*="[sdg_goal]"],select[id*="[sdg_target]"],select[id*="[code]"],input[id*="[text]"]',
        case7 = 'input[id*="[vocabulary_uri]"],select[id*="[category_code]"],select[id*="[sdg_target]"],select[id*="[code]"],input[id*="[text]"]',
        case8 = 'input[id*="[vocabulary_uri]"],select[id*="[category_code]"],select[id*="[sdg_goal]"],select[id*="[code]"],input[id*="[text]"]',
        case98_99 = 'select[id*="[category_code]"],select[id*="[sdg_goal]"],select[id*="[sdg_target]"],select[id*="[code]"]',
        default_hide = 'select[id*="[category_code]"],select[id*="[sdg_goal]"],select[id*="[sdg_target]"],select[id*="[code]"],input[id*="[vocabulary_uri]"]';

    switch (value) {
      case '1':
        index.closest('.form-field-group').find(case1_show).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case1).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
        break;

      case '2':
        index.closest('.form-field-group').find(case2_show).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case2).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
        break;

      case '7':
        index.closest('.form-field-group').find(case7_show).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case7).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
        break;

      case '8':
        index.closest('.form-field-group').find(case8_show).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case8).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
        break;

      case '98':
        index.closest('.form-field-group').find(case98_99_show).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case98_99).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
        break;

      case '99':
        index.closest('.form-field-group').find(case98_99_show).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case98_99).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
        break;

      default:
        index.closest('.form-field-group').find(default_show).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(default_hide).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
    }
  };
  /**
   *  Recipient Vocabulary Form Page
   *
   * @Logic hide vocabulary-uri and codes field based on '@vocabulary' field value
   */


  DynamicField.prototype.recipientVocabularyHideField = function () {
    var _this = this;

    var region_vocabulary = (0, jquery_1["default"])('select[id*="region_vocabulary"]');

    if (region_vocabulary.length > 0) {
      jquery_1["default"].each(region_vocabulary, function (index, region_vocab) {
        var _a;

        var data = (_a = (0, jquery_1["default"])(region_vocab).val()) !== null && _a !== void 0 ? _a : '1';

        _this.hideRecipientRegionField((0, jquery_1["default"])(region_vocab), data.toString());
      });
      region_vocabulary.on('select2:select', function (e) {
        var data = e.params.data.id;
        var target = e.target;

        _this.hideRecipientRegionField((0, jquery_1["default"])(target), data);
      });
      region_vocabulary.on('select2:clear', function (e) {
        var target = e.target;

        _this.hideRecipientRegionField((0, jquery_1["default"])(target), '1');
      });
    }
  };
  /**
   * Hides Recipient Region Form Fields
   */


  DynamicField.prototype.hideRecipientRegionField = function (index, value) {
    var case1_show = 'select[id*="[region_code]"]',
        case2_show = 'input[id*="[custom_code]"], input[id*="[code]"]',
        case99_show = 'input[id*="[custom_code]"],input[id*="[vocabulary_uri]"], input[id*="[code]"]',
        case1 = 'input[id*="[custom_code]"],input[id*="[vocabulary_uri]"],input[id*="[code]"]',
        case2 = 'select[id*="[region_code]"],input[id*="[vocabulary_uri]"]',
        case99 = 'select[id*="[region_code]"]';

    switch (value) {
      case '1':
        console.log(case1_show);
        index.closest('.form-field-group').find(case1_show).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case1).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
        break;

      case '2':
        index.closest('.form-field-group').find(case2_show).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case2).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
        break;

      case '99':
        index.closest('.form-field-group').find(case99_show).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case99).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
        break;

      default:
        index.closest('.form-field-group').find(case2_show).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case2).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
    }
  };
  /**
   * Updates Activity identifier
   */


  DynamicField.prototype.updateActivityIdentifier = function () {
    var activity_identifier = (0, jquery_1["default"])('#activity_identifier');

    if (activity_identifier.length > 0) {
      activity_identifier.on('keyup', function () {
        (0, jquery_1["default"])('#iati_identifier_text').val((0, jquery_1["default"])('.identifier').attr('activity_identifier') + "-".concat((0, jquery_1["default"])(this).val()));
      });
    }
  };
  /**
   * Tag Form Page
   *
   * @Logic hide vocabulary-uri and codes field based on '@vocabulary' field value
   */


  DynamicField.prototype.tagVocabularyHideField = function () {
    var _this = this;

    var tag_vocabulary = (0, jquery_1["default"])('select[id*="tag_vocabulary"]');

    if (tag_vocabulary.length > 0) {
      jquery_1["default"].each(tag_vocabulary, function (index, tag) {
        var _a;

        var data = (_a = (0, jquery_1["default"])(tag).val()) !== null && _a !== void 0 ? _a : '1';

        _this.hideTagField((0, jquery_1["default"])(tag), data.toString());
      });
      tag_vocabulary.on('select2:select', function (e) {
        var data = e.params.data.id;
        var target = e.target;

        _this.hideTagField((0, jquery_1["default"])(target), data);
      });
      tag_vocabulary.on('select2:clear', function (e) {
        var target = e.target;

        _this.hideTagField((0, jquery_1["default"])(target), '1');
      });
    }
  };
  /**
   * Hide Tag Form fields
   */


  DynamicField.prototype.hideTagField = function (index, value) {
    var case1_show = 'input[id*="[tag_text]"]',
        case2_show = 'select[id*="[goals_tag_code]"]',
        case3_show = 'select[id*="[targets_tag_code]"]',
        case99_show = 'input[id*="[tag_text]"], input[id*="[vocabulary_uri]"]',
        case1 = 'select[id*="[goals_tag_code]"],select[id*="[targets_tag_code]"],input[id*="[vocabulary_uri]"]',
        case2 = 'input[id*="[vocabulary_uri]"],select[id*="[targets_tag_code]"],select[id*="[targets_tag_code]"],input[id*="[tag_text]"]',
        case3 = 'input[id*="[vocabulary_uri]"],select[id*="[goals_tag_code]"],input[id*="[tag_text]"]',
        case99 = 'select[id*="[goals_tag_code]"],select[id*="[targets_tag_code]"]';

    switch (value) {
      case '1':
        index.closest('.form-field-group').find(case1_show).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case1).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
        break;

      case '2':
        index.closest('.form-field-group').find(case2_show).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case2).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
        break;

      case '3':
        index.closest('.form-field-group').find(case3_show).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case3).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
        break;

      case '99':
        index.closest('.form-field-group').find(case99_show).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case99).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
        break;

      default:
        index.closest('.form-field-group').find(case1_show).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case1).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
    }
  };

  return DynamicField;
}();

exports.DynamicField = DynamicField;

/***/ }),

/***/ "./resources/assets/js/scripts/formbuilder.ts":
/*!****************************************************!*\
  !*** ./resources/assets/js/scripts/formbuilder.ts ***!
  \****************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {



var __importDefault = this && this.__importDefault || function (mod) {
  return mod && mod.__esModule ? mod : {
    "default": mod
  };
};

Object.defineProperty(exports, "__esModule", ({
  value: true
}));

var jquery_1 = __importDefault(__webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js"));

__webpack_require__(/*! select2 */ "./node_modules/select2/dist/js/select2.js");

var DynamicField_1 = __webpack_require__(/*! ./DynamicField */ "./resources/assets/js/scripts/DynamicField.ts");

var dynamicField = new DynamicField_1.DynamicField();

var FormBuilder =
/** @class */
function () {
  function FormBuilder() {} // adds new collection of sub-element


  FormBuilder.prototype.addForm = function (ev) {
    ev.preventDefault();
    var target = ev.target;
    var container = (0, jquery_1["default"])(target).attr('form_type') ? (0, jquery_1["default"])(".collection-container[form_type ='".concat((0, jquery_1["default"])(target).attr('form_type'), "']")) : (0, jquery_1["default"])('.collection-container');
    var count = (0, jquery_1["default"])(target).attr('child_count') ? parseInt((0, jquery_1["default"])(target).attr('child_count')) + 1 : (0, jquery_1["default"])(target).parent().find('.form-child-body').length;
    var parent_count = (0, jquery_1["default"])(target).attr('parent_count') ? parseInt((0, jquery_1["default"])(target).attr('parent_count')) : (0, jquery_1["default"])(target).parent('.subelement').prevAll('.multi-form').length;
    var wrapper_parent_count = (0, jquery_1["default"])(target).attr('wrapped_parent_count') ? parseInt((0, jquery_1["default"])(target).attr('wrapped_parent_count')) : (0, jquery_1["default"])(target).parent('.subelement').find('.wrapped-child-body').length;
    var proto = container.data('prototype').replace(/__PARENT_NAME__/g, parent_count);

    if ((0, jquery_1["default"])(target).attr('has_child_collection')) {
      proto = proto.replace(/__WRAPPER_NAME__/g, count);
      proto = proto.replace(/__NAME__/g, 0);
    } else {
      proto = proto.replace(/__NAME__/g, count);
      proto = proto.replace(/__WRAPPER_NAME__/g, wrapper_parent_count);
    }

    (0, jquery_1["default"])(target).prev().append((0, jquery_1["default"])(proto));

    if ((0, jquery_1["default"])(target).attr('has_child_collection')) {
      (0, jquery_1["default"])(target).prev('.subelement').children('.wrapped-child-body').last().find('.add_to_collection').attr('wrapped_parent_count', count);
      (0, jquery_1["default"])(target).prev('.subelement').children('.wrapped-child-body').last().find('.add_to_collection').attr('parent_count', parent_count);
    }

    (0, jquery_1["default"])(target).prev().find('.wrapped-child-body').last().find('.add_to_collection').attr('wrapper_parent_count', wrapper_parent_count !== null && wrapper_parent_count !== void 0 ? wrapper_parent_count : 0);

    if ((0, jquery_1["default"])(target).attr('form_type')) {
      (0, jquery_1["default"])(target).prev().last().find('.select2').select2({
        placeholder: 'Select an option',
        allowClear: true
      });
      (0, jquery_1["default"])(this).find('.sub-attribute').wrapAll((0, jquery_1["default"])('<div class="form-field-group flex flex-wrap rounded-br-lg border-y border-r border-spring-50 sub-attribute-wrapper"></div>'));
      (0, jquery_1["default"])(target).prev('.subelement').children('.wrapped-child-body').last().find('.sub-attribute').wrapAll((0, jquery_1["default"])('<div class="form-field-group flex flex-wrap rounded-br-lg border-y border-r border-spring-50 sub-attribute-wrapper mt-6"></div>'));
    } else {
      (0, jquery_1["default"])(target).parent().find('.form-child-body').last().find('.select2').select2({
        placeholder: 'Select an option',
        allowClear: true
      });
    }

    (0, jquery_1["default"])(target).attr('child_count', count);
    dynamicField.aidTypeVocabularyHideField();
    dynamicField.sectorVocabularyHideField();
  }; // adds parent collection


  FormBuilder.prototype.addParentForm = function (ev) {
    ev.preventDefault();
    var target = ev.target;
    var container = (0, jquery_1["default"])(target).attr('form_type') ? (0, jquery_1["default"])(".parent-collection[form_type ='".concat((0, jquery_1["default"])(target).attr('form_type'), "']")) : (0, jquery_1["default"])('.parent-collection');
    var count = (0, jquery_1["default"])(target).attr('parent_count') ? parseInt((0, jquery_1["default"])(target).attr('parent_count')) + 1 : ((0, jquery_1["default"])(target).prev().find('.multi-form').length ? (0, jquery_1["default"])(target).prev().find('.multi-form').length : (0, jquery_1["default"])(target).prev().find('.wrapped-child-body').length) + 1;
    var proto = container.data('prototype').replace(/__PARENT_NAME__/g, count);
    proto = proto.replace(/__NAME__/g, 0);
    (0, jquery_1["default"])(target).prev().append((0, jquery_1["default"])(proto));
    (0, jquery_1["default"])(target).prev().find('.multi-form').last().find('.select2').select2({
      placeholder: 'Select an option',
      allowClear: true
    });
    (0, jquery_1["default"])(target).prev().find('.multi-form').last().find('.add_to_collection').attr('parent_count', count);
    this.addWrapperOnAdd(target);
    (0, jquery_1["default"])(target).attr('parent_count', count);
    dynamicField.humanitarianScopeHideVocabularyUri();
    dynamicField.countryBudgetHideCodeField();
    dynamicField.sectorVocabularyHideField();
    dynamicField.recipientVocabularyHideField();
    dynamicField.policyVocabularyHideField();
    dynamicField.tagVocabularyHideField();
    dynamicField.transactionAidTypeVocabularyHideField();
    dynamicField.indicatorReferenceHideFieldUri();
  }; // deletes collection


  FormBuilder.prototype.deleteForm = function (ev) {
    ev.preventDefault();
    var target = ev.target;
    var collectionLength = (0, jquery_1["default"])('.multi-form').length ? (0, jquery_1["default"])(target).closest('.subelement').find('.form-child-body').length : (0, jquery_1["default"])('.form-child-body').length;
    var count = (0, jquery_1["default"])('.add_to_collection').attr('child_count') ? parseInt((0, jquery_1["default"])('.add_to_collection').attr('child_count')) + 1 : collectionLength;
    (0, jquery_1["default"])('.add_to_collection').attr('child_count', count);

    if (collectionLength > 1) {
      var tg = (0, jquery_1["default"])(target).closest('.form-child-body');
      tg.next('.error').remove();
      tg.remove();
    }
  }; // deletes parent collection


  FormBuilder.prototype.deleteParentForm = function (ev) {
    ev.preventDefault();
    var target = ev.target;
    var collectionLength = (0, jquery_1["default"])('.subelement').length;
    var count = (0, jquery_1["default"])('.add_to_parent').attr('child_count') ? parseInt((0, jquery_1["default"])('.add_to_parent').attr('child_count')) + 1 : collectionLength;
    (0, jquery_1["default"])('.add_to_parent').attr('child_count', count);
    (0, jquery_1["default"])('.add_to_parent').attr('parent_count', count);

    if (collectionLength > 2) {
      (0, jquery_1["default"])(target).parent().remove();
    }
  }; //add wrapper div around the attributes


  FormBuilder.prototype.addWrapper = function () {
    (0, jquery_1["default"])('.multi-form').each(function () {
      (0, jquery_1["default"])(this).find('.attribute').wrapAll((0, jquery_1["default"])('<div class="form-field-group flex flex-wrap rounded-br-lg border-y border-r border-spring-50 attribute-wrapper mb-4"></div>'));
    });
    (0, jquery_1["default"])('.subelement').find('.wrapped-child-body').each(function () {
      (0, jquery_1["default"])(this).find('.sub-attribute').wrapAll((0, jquery_1["default"])('<div class="form-field-group flex flex-wrap rounded-br-lg border-y border-r border-spring-50 sub-attribute-wrapper mb-4"></div>'));
    });
    var formField = (0, jquery_1["default"])('form>.form-field');

    if (formField.length > 0) {
      formField.wrapAll('<div class="form-field-group-outer grid xl:grid-cols-2 mb-6 -mx-3 gap-y-6"></div>');
    }
  };

  FormBuilder.prototype.addWrapperOnAdd = function (target) {
    (0, jquery_1["default"])(target).prev().find('.multi-form').last().find('.attribute').wrapAll((0, jquery_1["default"])('<div class="form-field-group grid xl:grid-cols-2 rounded-br-lg border-y border-r border-spring-50 attribute-wrapper mb-4"></div>'));
    (0, jquery_1["default"])(target).prev().find('.multi-form').last().find('.subelement').find('.wrapped-child-body').each(function () {
      (0, jquery_1["default"])(this).find('.sub-attribute').wrapAll((0, jquery_1["default"])('<div class="form-field-group flex flex-wrap rounded-br-lg border-y border-r border-spring-50 sub-attribute-wrapper mb-4"></div>'));
    });
  };

  FormBuilder.prototype.textAreaHeight = function (ev) {
    var target = ev.target;
    var height = target.scrollHeight;
    (0, jquery_1["default"])(target).css('height', height);
  };

  FormBuilder.prototype.addToCollection = function () {
    var _this = this;

    (0, jquery_1["default"])('body').on('click', '.add_to_collection', function (event) {
      _this.addForm(event);
    });
    (0, jquery_1["default"])('.add_to_parent').on('click', function (event) {
      _this.addParentForm(event);
    });
  };

  FormBuilder.prototype.deleteCollection = function () {
    var _this = this;

    var deleteConfirmation = (0, jquery_1["default"])('.delete-confirmation'),
        cancelPopup = '.cancel-popup',
        deleteConfirm = '.delete-confirm';
    var deleteIndex = {},
        childOrParent = '';
    (0, jquery_1["default"])('body').on('click', '.delete', function (event) {
      deleteConfirmation.fadeIn();
      deleteIndex = event;
      childOrParent = 'child';
    });
    (0, jquery_1["default"])('body').on('click', cancelPopup, function () {
      deleteConfirmation.fadeOut();
      deleteIndex = {};
      childOrParent = '';
    });
    (0, jquery_1["default"])('body').on('click', deleteConfirm, function () {
      if (childOrParent === 'child') {
        _this.deleteForm(deleteIndex);
      } else if (childOrParent === 'parent') {
        _this.deleteParentForm(deleteIndex);
      }

      deleteConfirmation.fadeOut();
      deleteIndex = {};
      childOrParent = '';
    });
    (0, jquery_1["default"])('body').on('click', '.delete-parent', function (event) {
      deleteConfirmation.fadeIn();
      deleteIndex = event;
      childOrParent = 'parent';
    });
    (0, jquery_1["default"])('.select2').select2({
      placeholder: 'Select an option',
      allowClear: true
    });
    (0, jquery_1["default"])('body').on('change', 'input[id*="[document]"]', function () {
      var _a, _b, _c;

      var endpoint = (_a = (0, jquery_1["default"])('.endpoint').attr('endpoint')) !== null && _a !== void 0 ? _a : '';
      var file_name = ((_b = (0, jquery_1["default"])(this).val()) !== null && _b !== void 0 ? _b : '').toString();
      (0, jquery_1["default"])(this).closest('.form-field-group').find('input[id*="[url]"]').val("".concat(endpoint, "/").concat((_c = file_name === null || file_name === void 0 ? void 0 : file_name.split('\\').pop()) === null || _c === void 0 ? void 0 : _c.replace(' ', '_')));
    });
  };

  return FormBuilder;
}();

(0, jquery_1["default"])(function () {
  var formBuilder = new FormBuilder();
  formBuilder.addWrapper();
  dynamicField.hideShowFormFields();
  dynamicField.updateActivityIdentifier();
  formBuilder.addToCollection();
  formBuilder.deleteCollection();
  /**
   * Text area height on typing
   */

  var textAreaTarget = (0, jquery_1["default"])('textarea.form__input');

  if (textAreaTarget.length > 0) {
    (0, jquery_1["default"])('body').on('input', 'textarea.form__input', function (event) {
      formBuilder.textAreaHeight(event);
    });
  }

  (0, jquery_1["default"])('body').on('select2:open', '.select2', function () {
    var select_search = document.querySelector('.select2-search__field');

    if (select_search) {
      select_search.focus();
    }
  });
  /**
   * checks registration agency, country and registration number to deduce identifier
   */

  updateRegistrationAgency((0, jquery_1["default"])('#organization_country'));
  (0, jquery_1["default"])('#organisation_identifier').attr('disabled', 'disabled');

  function updateRegistrationAgency(country) {
    if (country.val()) {
      jquery_1["default"].ajax({
        url: '/organisation/agency/' + country.val()
      }).then(function (response) {
        var _a;

        var current_val = (_a = (0, jquery_1["default"])('#organization_registration_agency').val()) !== null && _a !== void 0 ? _a : '';
        var val = false;
        (0, jquery_1["default"])('#organization_registration_agency').empty();

        for (var data in response.data) {
          if (data === current_val) {
            val = true;
          }

          (0, jquery_1["default"])('#organization_registration_agency').append(new Option(response.data[data], data, true, true)).val('').trigger('change');
        }

        (0, jquery_1["default"])('#organization_registration_agency').val(val ? current_val : '').trigger('change');
      });
    }
  }

  (0, jquery_1["default"])('body').on('select2:select', '#organization_country', function () {
    updateRegistrationAgency((0, jquery_1["default"])(this));
  });
  (0, jquery_1["default"])('body').on('select2:select', '#organization_registration_agency', function () {
    var identifier = (0, jquery_1["default"])(this).val() + '-' + (0, jquery_1["default"])('#registration_number').val();
    (0, jquery_1["default"])('#organisation_identifier').val(identifier);
  });
  (0, jquery_1["default"])('body').on('select2:clear', '#organization_registration_agency', function () {
    var identifier = '-' + (0, jquery_1["default"])('#registration_number').val();
    (0, jquery_1["default"])('#organisation_identifier').val(identifier);
  });
  (0, jquery_1["default"])('body').on('keyup', '#registration_number', function () {
    var identifier = (0, jquery_1["default"])('#organization_registration_agency').val() + '-' + (0, jquery_1["default"])(this).val();
    (0, jquery_1["default"])('#organisation_identifier').val(identifier);
  });
});

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["/js/vendor"], () => (__webpack_exec__("./resources/assets/js/scripts/formbuilder.ts")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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QUMsR0FBRzFKLFFBQVEsV0FBWixFQUFzQixtQ0FBdEIsRUFBMkRvQixHQUEzRCxLQUFtRSxHQUFuRSxHQUF5RSxDQUFDLEdBQUdwQixRQUFRLFdBQVosRUFBc0IsSUFBdEIsRUFBNEJvQixHQUE1QixFQUExRjtBQUNBLEtBQUMsR0FBR3BCLFFBQVEsV0FBWixFQUFzQiwwQkFBdEIsRUFBa0RvQixHQUFsRCxDQUFzRHNJLFVBQXREO0FBQ0gsR0FIRDtBQUlILENBaEVEIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9qcy9zY3JpcHRzL0R5bmFtaWNGaWVsZC50cyIsIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2pzL3NjcmlwdHMvZm9ybWJ1aWxkZXIudHMiXSwic291cmNlc0NvbnRlbnQiOlsiXCJ1c2Ugc3RyaWN0XCI7XHJcbnZhciBfX2ltcG9ydERlZmF1bHQgPSAodGhpcyAmJiB0aGlzLl9faW1wb3J0RGVmYXVsdCkgfHwgZnVuY3Rpb24gKG1vZCkge1xyXG4gICAgcmV0dXJuIChtb2QgJiYgbW9kLl9fZXNNb2R1bGUpID8gbW9kIDogeyBcImRlZmF1bHRcIjogbW9kIH07XHJcbn07XHJcbk9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBcIl9fZXNNb2R1bGVcIiwgeyB2YWx1ZTogdHJ1ZSB9KTtcclxuZXhwb3J0cy5EeW5hbWljRmllbGQgPSB2b2lkIDA7XHJcbnZhciBqcXVlcnlfMSA9IF9faW1wb3J0RGVmYXVsdChyZXF1aXJlKFwianF1ZXJ5XCIpKTtcclxucmVxdWlyZShcInNlbGVjdDJcIik7XHJcbnZhciBEeW5hbWljRmllbGQgPSAvKiogQGNsYXNzICovIChmdW5jdGlvbiAoKSB7XHJcbiAgICBmdW5jdGlvbiBEeW5hbWljRmllbGQoKSB7XHJcbiAgICB9XHJcbiAgICAvKipcclxuICAgICAqIEhpZGUgYW5kIFNob3cgZGlmZmVyZW50IGZvcm0gZmllbGRzIGJhc2VkIG9uIHZvY2FidWxhcnkgYW5kIG90aGVyIHR5cGVzXHJcbiAgICAgKi9cclxuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaGlkZVNob3dGb3JtRmllbGRzID0gZnVuY3Rpb24gKCkge1xyXG4gICAgICAgIHRoaXMuaHVtYW5pdGFyaWFuU2NvcGVIaWRlVm9jYWJ1bGFyeVVyaSgpO1xyXG4gICAgICAgIHRoaXMuY291bnRyeUJ1ZGdldEhpZGVDb2RlRmllbGQoKTtcclxuICAgICAgICB0aGlzLmFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XHJcbiAgICAgICAgdGhpcy5zZWN0b3JWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XHJcbiAgICAgICAgdGhpcy5wb2xpY3lWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XHJcbiAgICAgICAgdGhpcy5yZWNpcGllbnRWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XHJcbiAgICAgICAgdGhpcy5zZWN0b3JWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XHJcbiAgICAgICAgdGhpcy50YWdWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XHJcbiAgICAgICAgdGhpcy50cmFuc2FjdGlvbkFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XHJcbiAgICAgICAgdGhpcy5pbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGRVcmkoKTtcclxuICAgIH07XHJcbiAgICAvKipcclxuICAgICAqIEh1bWFuaXRhcmlhbiBTY29wZSBGb3JtIFBhZ2VcclxuICAgICAqXHJcbiAgICAgKiBATG9naWMgaGlkZSB2b2NhYnVsYXJ5LXVyaSBmaWVsZCBiYXNlZCBvbiAnQHZvY2FidWxhcnknIGZpZWxkIHZhbHVlXHJcbiAgICAgKi9cclxuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaHVtYW5pdGFyaWFuU2NvcGVIaWRlVm9jYWJ1bGFyeVVyaSA9IGZ1bmN0aW9uICgpIHtcclxuICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xyXG4gICAgICAgIHZhciBodW1hbml0YXJpYW5TY29wZVZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdFtpZF49XCJodW1hbml0YXJpYW5fc2NvcGVcIl1baWQqPVwiW3ZvY2FidWxhcnldXCJdJyk7XHJcbiAgICAgICAgaWYgKGh1bWFuaXRhcmlhblNjb3BlVm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XHJcbiAgICAgICAgICAgIC8vIGhpZGUgZmllbGRzIG9uIHBhZ2UgbG9hZFxyXG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2goaHVtYW5pdGFyaWFuU2NvcGVWb2NhYnVsYXJ5LCBmdW5jdGlvbiAoaW5kZXgsIHNjb3BlKSB7XHJcbiAgICAgICAgICAgICAgICB2YXIgX2E7XHJcbiAgICAgICAgICAgICAgICB2YXIgdmFsID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHNjb3BlKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJyc7XHJcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlSHVtYW5pdGFyaWFuU2NvcGVGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoc2NvcGUpLCB2YWwudG9TdHJpbmcoKSk7XHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICAvLyBoaWRlL3Nob3cgZmllbGRzIG9uIHZhbHVlIGNoYW5nZVxyXG4gICAgICAgICAgICBodW1hbml0YXJpYW5TY29wZVZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgZnVuY3Rpb24gKGUpIHtcclxuICAgICAgICAgICAgICAgIHZhciB2YWwgPSBlLnBhcmFtcy5kYXRhLmlkO1xyXG4gICAgICAgICAgICAgICAgdmFyIGluZGV4ID0gZS50YXJnZXQ7XHJcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlSHVtYW5pdGFyaWFuU2NvcGVGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaW5kZXgpLCB2YWwpO1xyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgLy8gaGlkZS9zaG93IGZpZWxkcyBvbiB2YWx1ZSBjbGVhclxyXG4gICAgICAgICAgICBodW1hbml0YXJpYW5TY29wZVZvY2FidWxhcnkub24oJ3NlbGVjdDI6Y2xlYXInLCBmdW5jdGlvbiAoZSkge1xyXG4gICAgICAgICAgICAgICAgdmFyIGluZGV4ID0gZS50YXJnZXQ7XHJcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlSHVtYW5pdGFyaWFuU2NvcGVGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaW5kZXgpLCAnJyk7XHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgIH1cclxuICAgIH07XHJcbiAgICAvLyBoaWRlIGNvdW50cnkgYnVkZ2V0IGJhc2VkIG9uIHZvY2FidWxhcnlcclxuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaGlkZUh1bWFuaXRhcmlhblNjb3BlRmllbGQgPSBmdW5jdGlvbiAoaW5kZXgsIHZhbHVlKSB7XHJcbiAgICAgICAgdmFyIGh1bWFuaXRhcmlhblNjb3BlSGlkZVZvY2FidWxhcnlVcmkgPSAnaW5wdXRbaWRePVwiaHVtYW5pdGFyaWFuX3Njb3BlXCJdW2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0nO1xyXG4gICAgICAgIGlmICh2YWx1ZSA9PT0gJzk5Jykge1xyXG4gICAgICAgICAgICBpbmRleFxyXG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcclxuICAgICAgICAgICAgICAgIC5maW5kKGh1bWFuaXRhcmlhblNjb3BlSGlkZVZvY2FidWxhcnlVcmkpXHJcbiAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcclxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXHJcbiAgICAgICAgICAgICAgICAuc2hvdygpO1xyXG4gICAgICAgIH1cclxuICAgICAgICBlbHNlIHtcclxuICAgICAgICAgICAgaW5kZXhcclxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXHJcbiAgICAgICAgICAgICAgICAuZmluZChodW1hbml0YXJpYW5TY29wZUhpZGVWb2NhYnVsYXJ5VXJpKVxyXG4gICAgICAgICAgICAgICAgLnZhbCgnJylcclxuICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxyXG4gICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXHJcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxyXG4gICAgICAgICAgICAgICAgLmhpZGUoKTtcclxuICAgICAgICB9XHJcbiAgICB9O1xyXG4gICAgLyoqXHJcbiAgICogSHVtYW5pdGFyaWFuIFNjb3BlIEZvcm0gUGFnZVxyXG4gICAqXHJcbiAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxyXG4gICAqL1xyXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5pbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGRVcmkgPSBmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcclxuICAgICAgICB2YXIgcmVmZXJlbmNlVm9jYWJ1bGFyeSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnc2VsZWN0W2lkXj1cInJlZmVyZW5jZVwiXVtpZCo9XCJbdm9jYWJ1bGFyeV1cIl0nKTtcclxuICAgICAgICBpZiAocmVmZXJlbmNlVm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XHJcbiAgICAgICAgICAgIC8vIGhpZGUgZmllbGRzIG9uIHBhZ2UgbG9hZFxyXG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2gocmVmZXJlbmNlVm9jYWJ1bGFyeSwgZnVuY3Rpb24gKGluZGV4LCBzY29wZSkge1xyXG4gICAgICAgICAgICAgICAgdmFyIF9hO1xyXG4gICAgICAgICAgICAgICAgdmFyIHZhbCA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShzY29wZSkudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcnO1xyXG4gICAgICAgICAgICAgICAgX3RoaXMuaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShzY29wZSksIHZhbC50b1N0cmluZygpKTtcclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgIC8vIGhpZGUvc2hvdyBmaWVsZHMgb24gdmFsdWUgY2hhbmdlXHJcbiAgICAgICAgICAgIHJlZmVyZW5jZVZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgZnVuY3Rpb24gKGUpIHtcclxuICAgICAgICAgICAgICAgIHZhciB2YWwgPSBlLnBhcmFtcy5kYXRhLmlkO1xyXG4gICAgICAgICAgICAgICAgdmFyIGluZGV4ID0gZS50YXJnZXQ7XHJcbiAgICAgICAgICAgICAgICBfdGhpcy5pbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGluZGV4KSwgdmFsKTtcclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgIC8vIGhpZGUvc2hvdyBmaWVsZHMgb24gdmFsdWUgY2xlYXJcclxuICAgICAgICAgICAgcmVmZXJlbmNlVm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIGZ1bmN0aW9uIChlKSB7XHJcbiAgICAgICAgICAgICAgICB2YXIgaW5kZXggPSBlLnRhcmdldDtcclxuICAgICAgICAgICAgICAgIF90aGlzLmluZGljYXRvclJlZmVyZW5jZUhpZGVGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaW5kZXgpLCAnJyk7XHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgIH1cclxuICAgIH07XHJcbiAgICAvLyBoaWRlIGNvdW50cnkgYnVkZ2V0IGJhc2VkIG9uIHZvY2FidWxhcnlcclxuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkID0gZnVuY3Rpb24gKGluZGV4LCB2YWx1ZSkge1xyXG4gICAgICAgIHZhciByZWZlcmVuY2VVcmkgPSAnaW5wdXRbaWRePVwicmVmZXJlbmNlXCJdW2lkKj1cIltpbmRpY2F0b3JfdXJpXVwiXSc7XHJcbiAgICAgICAgaWYgKHZhbHVlID09PSAnOTknKSB7XHJcbiAgICAgICAgICAgIGluZGV4XHJcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxyXG4gICAgICAgICAgICAgICAgLmZpbmQocmVmZXJlbmNlVXJpKVxyXG4gICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXHJcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxyXG4gICAgICAgICAgICAgICAgLnNob3coKTtcclxuICAgICAgICB9XHJcbiAgICAgICAgZWxzZSB7XHJcbiAgICAgICAgICAgIGluZGV4XHJcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxyXG4gICAgICAgICAgICAgICAgLmZpbmQocmVmZXJlbmNlVXJpKVxyXG4gICAgICAgICAgICAgICAgLnZhbCgnJylcclxuICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxyXG4gICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXHJcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxyXG4gICAgICAgICAgICAgICAgLmhpZGUoKTtcclxuICAgICAgICB9XHJcbiAgICB9O1xyXG4gICAgLyoqXHJcbiAgICAgKiBDb3VudHJ5IEJ1ZGdldCBGb3JtIFBhZ2VcclxuICAgICAqXHJcbiAgICAgKiBATG9naWMgc2hvdy9oaWRlICdjb2RlJyBmaWVsZCBiYXNlZCBvbiAnQHZvY2FidWxhcnknIGZpZWxkIHZhbHVlXHJcbiAgICAgKi9cclxuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuY291bnRyeUJ1ZGdldEhpZGVDb2RlRmllbGQgPSBmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcclxuICAgICAgICB2YXIgX2E7XHJcbiAgICAgICAgdmFyIGNvdW50cnlCdWRnZXRWb2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3QjY291bnRyeV9idWRnZXRfdm9jYWJ1bGFyeScpO1xyXG4gICAgICAgIGlmIChjb3VudHJ5QnVkZ2V0Vm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XHJcbiAgICAgICAgICAgIC8vIGhpZGUvc2hvdyBvbiBwYWdlIGxvYWRcclxuICAgICAgICAgICAgdmFyIHZhbCA9IChfYSA9IGNvdW50cnlCdWRnZXRWb2NhYnVsYXJ5LnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnMSc7XHJcbiAgICAgICAgICAgIHRoaXMuaGlkZUNvdW50cnlCdWRnZXRGaWVsZCh2YWwudG9TdHJpbmcoKSk7XHJcbiAgICAgICAgICAgIC8vIGhpZGUvc2hvdyBvbiB2YWx1ZSBjaGFuZ2VcclxuICAgICAgICAgICAgY291bnRyeUJ1ZGdldFZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgZnVuY3Rpb24gKGUpIHtcclxuICAgICAgICAgICAgICAgIHZhciB2YWwgPSBlLnBhcmFtcy5kYXRhLmlkO1xyXG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZUNvdW50cnlCdWRnZXRGaWVsZCh2YWwpO1xyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgLy9oaWRlL3Nob3cgYmFzZWQgb24gdmFsdWUgY2xlYXJlZFxyXG4gICAgICAgICAgICBjb3VudHJ5QnVkZ2V0Vm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIGZ1bmN0aW9uICgpIHtcclxuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVDb3VudHJ5QnVkZ2V0RmllbGQoJycpO1xyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICB9XHJcbiAgICB9O1xyXG4gICAgLyoqXHJcbiAgICAgKiBIaWRlIENvdW50cnkgQnVkZ2V0IEZpZWxkc1xyXG4gICAgICovXHJcbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmhpZGVDb3VudHJ5QnVkZ2V0RmllbGQgPSBmdW5jdGlvbiAodmFsdWUpIHtcclxuICAgICAgICB2YXIgY291bnRyeUJ1ZGdldENvZGVJbnB1dCA9ICdpbnB1dFtpZF49XCJidWRnZXRfaXRlbVwiXVtpZCo9XCJbY29kZV90ZXh0XVwiXScsIGNvdW50cnlCdWRnZXRDb2RlU2VsZWN0ID0gJ3NlbGVjdFtpZF49XCJidWRnZXRfaXRlbVwiXVtpZCo9XCJbY29kZV1cIl0nO1xyXG4gICAgICAgIGlmICh2YWx1ZSA9PT0gJzEnKSB7XHJcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShjb3VudHJ5QnVkZ2V0Q29kZVNlbGVjdClcclxuICAgICAgICAgICAgICAgIC52YWwoJycpXHJcbiAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJykuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxyXG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcclxuICAgICAgICAgICAgICAgIC5oaWRlKCk7XHJcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShjb3VudHJ5QnVkZ2V0Q29kZUlucHV0KS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJykuc2hvdygpO1xyXG4gICAgICAgIH1cclxuICAgICAgICBlbHNlIHtcclxuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGNvdW50cnlCdWRnZXRDb2RlU2VsZWN0KS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJykuc2hvdygpO1xyXG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoY291bnRyeUJ1ZGdldENvZGVJbnB1dClcclxuICAgICAgICAgICAgICAgIC52YWwoJycpXHJcbiAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcclxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXHJcbiAgICAgICAgICAgICAgICAuaGlkZSgpO1xyXG4gICAgICAgIH1cclxuICAgIH07XHJcbiAgICAvKipcclxuICAgICAqIEFpZFR5cGUgRm9ybSBQYWdlXHJcbiAgICAgKlxyXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgYW5kIGNvZGVzIGZpZWxkIGJhc2VkIG9uICdAdm9jYWJ1bGFyeScgZmllbGQgdmFsdWVcclxuICAgICAqL1xyXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5haWRUeXBlVm9jYWJ1bGFyeUhpZGVGaWVsZCA9IGZ1bmN0aW9uICgpIHtcclxuICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xyXG4gICAgICAgIHZhciBhaWR0eXBlX3ZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdFtpZCo9XCJkZWZhdWx0X2FpZF90eXBlX3ZvY2FidWxhcnlcIl0nKTtcclxuICAgICAgICBpZiAoYWlkdHlwZV92b2NhYnVsYXJ5Lmxlbmd0aCA+IDApIHtcclxuICAgICAgICAgICAganF1ZXJ5XzEuZGVmYXVsdC5lYWNoKGFpZHR5cGVfdm9jYWJ1bGFyeSwgZnVuY3Rpb24gKGluZGV4LCBpdGVtKSB7XHJcbiAgICAgICAgICAgICAgICB2YXIgX2E7XHJcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShpdGVtKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJzEnO1xyXG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZUFpZFR5cGVTZWxlY3RGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaXRlbSksIGRhdGEudG9TdHJpbmcoKSk7XHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICBhaWR0eXBlX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgZnVuY3Rpb24gKGUpIHtcclxuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gZS5wYXJhbXMuZGF0YS5pZDtcclxuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcclxuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVBaWRUeXBlU2VsZWN0RmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksIGRhdGEpO1xyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgYWlkdHlwZV92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKGUpIHtcclxuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcclxuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVBaWRUeXBlU2VsZWN0RmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksICcnKTtcclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgfVxyXG4gICAgfTtcclxuICAgIC8qKlxyXG4gICAgICogQWlkVHlwZSBGb3JtIFBhZ2VcclxuICAgICAqXHJcbiAgICAgKiBATG9naWMgaGlkZSB2b2NhYnVsYXJ5LXVyaSBhbmQgY29kZXMgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxyXG4gICAgICovXHJcbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLnRyYW5zYWN0aW9uQWlkVHlwZVZvY2FidWxhcnlIaWRlRmllbGQgPSBmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcclxuICAgICAgICB2YXIgYWlkdHlwZV92b2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3RbaWQqPVwiYWlkX3R5cGVfdm9jYWJ1bGFyeVwiXScpO1xyXG4gICAgICAgIGlmIChhaWR0eXBlX3ZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xyXG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2goYWlkdHlwZV92b2NhYnVsYXJ5LCBmdW5jdGlvbiAoaW5kZXgsIGl0ZW0pIHtcclxuICAgICAgICAgICAgICAgIHZhciBfYTtcclxuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGl0ZW0pLnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnMSc7XHJcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlVHJhbnNhY3Rpb25BaWRUeXBlU2VsZWN0RmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGl0ZW0pLCBkYXRhLnRvU3RyaW5nKCkpO1xyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgYWlkdHlwZV92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOnNlbGVjdCcsIGZ1bmN0aW9uIChlKSB7XHJcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IGUucGFyYW1zLmRhdGEuaWQ7XHJcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XHJcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlVHJhbnNhY3Rpb25BaWRUeXBlU2VsZWN0RmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksIGRhdGEpO1xyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgYWlkdHlwZV92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKGUpIHtcclxuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcclxuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVUcmFuc2FjdGlvbkFpZFR5cGVTZWxlY3RGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgJycpO1xyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICB9XHJcbiAgICB9O1xyXG4gICAgLyoqXHJcbiAgICAgKiBIaWRlIEFpZCBUeXBlIFNlbGVjdCBGaWVsZHNcclxuICAgICAqL1xyXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5oaWRlQWlkVHlwZVNlbGVjdEZpZWxkID0gZnVuY3Rpb24gKGluZGV4LCB2YWx1ZSkge1xyXG4gICAgICAgIHZhciBkZWZhdWx0X2FpZF90eXBlID0gJ3NlbGVjdFtpZCo9XCJbZGVmYXVsdF9haWRfdHlwZV1cIl0nLCBlYXJtYXJraW5nX2NhdGVnb3J5ID0gJ3NlbGVjdFtpZCo9XCJbZWFybWFya2luZ19jYXRlZ29yeV1cIl0nLCBlYXJtYXJraW5nX21vZGFsaXR5ID0gJ3NlbGVjdFtpZCo9XCJbZWFybWFya2luZ19tb2RhbGl0eV1cIl0nLCBjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXMgPSAnc2VsZWN0W2lkKj1cIltjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXNdXCJdJywgY2FzZTEgPSAnc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX2NhdGVnb3J5XVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfbW9kYWxpdHldXCJdLHNlbGVjdFtpZCo9XCJbY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzXVwiXScsIGNhc2UyID0gJ3NlbGVjdFtpZCo9XCJbZGVmYXVsdF9haWRfdHlwZV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX21vZGFsaXR5XVwiXSxzZWxlY3RbaWQqPVwiW2Nhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllc11cIl0nLCBjYXNlMyA9ICdzZWxlY3RbaWQqPVwiW2RlZmF1bHRfYWlkX3R5cGVdXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19jYXRlZ29yeV1cIl0sc2VsZWN0W2lkKj1cIltjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXNdXCJdJywgY2FzZTQgPSAnc2VsZWN0W2lkKj1cIltkZWZhdWx0X2FpZF90eXBlXVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfY2F0ZWdvcnldXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19tb2RhbGl0eV1cIl0nO1xyXG4gICAgICAgIHN3aXRjaCAodmFsdWUpIHtcclxuICAgICAgICAgICAgY2FzZSAnMic6XHJcbiAgICAgICAgICAgICAgICBpbmRleFxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoZWFybWFya2luZ19jYXRlZ29yeSlcclxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XHJcbiAgICAgICAgICAgICAgICBpbmRleFxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTIpXHJcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcclxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcclxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XHJcbiAgICAgICAgICAgICAgICBicmVhaztcclxuICAgICAgICAgICAgY2FzZSAnMyc6XHJcbiAgICAgICAgICAgICAgICBpbmRleFxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoZWFybWFya2luZ19tb2RhbGl0eSlcclxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XHJcbiAgICAgICAgICAgICAgICBpbmRleFxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTMpXHJcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcclxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcclxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XHJcbiAgICAgICAgICAgICAgICBicmVhaztcclxuICAgICAgICAgICAgY2FzZSAnNCc6XHJcbiAgICAgICAgICAgICAgICBpbmRleFxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzKVxyXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcclxuICAgICAgICAgICAgICAgIGluZGV4XHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcclxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlNClcclxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxyXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcclxuICAgICAgICAgICAgICAgIGJyZWFrO1xyXG4gICAgICAgICAgICBkZWZhdWx0OlxyXG4gICAgICAgICAgICAgICAgaW5kZXhcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGRlZmF1bHRfYWlkX3R5cGUpXHJcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcclxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xyXG4gICAgICAgICAgICAgICAgaW5kZXhcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxKVxyXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXHJcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXHJcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcclxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xyXG4gICAgICAgIH1cclxuICAgIH07XHJcbiAgICAvKipcclxuICAgICAqIEhpZGUgVHJhbnNhY3Rpb24gQWlkIFR5cGUgU2VsZWN0IEZpZWxkc1xyXG4gICAgICovXHJcbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmhpZGVUcmFuc2FjdGlvbkFpZFR5cGVTZWxlY3RGaWVsZCA9IGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcclxuICAgICAgICB2YXIgYWlkX3R5cGUgPSAnc2VsZWN0W2lkKj1cIlthaWRfdHlwZV9jb2RlXVwiXScsIGVhcm1hcmtpbmdfY2F0ZWdvcnkgPSAnc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX2NhdGVnb3J5XVwiXScsIGVhcm1hcmtpbmdfbW9kYWxpdHkgPSAnc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX21vZGFsaXR5XVwiXScsIGNhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllcyA9ICdzZWxlY3RbaWQqPVwiW2Nhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllc11cIl0nLCBjYXNlMSA9ICdzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfY2F0ZWdvcnldXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19tb2RhbGl0eV1cIl0sc2VsZWN0W2lkKj1cIltjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXNdXCJdJywgY2FzZTIgPSAnc2VsZWN0W2lkKj1cIlthaWRfdHlwZV9jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfbW9kYWxpdHldXCJdLHNlbGVjdFtpZCo9XCJbY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzXVwiXScsIGNhc2UzID0gJ3NlbGVjdFtpZCo9XCJbYWlkX3R5cGVfY29kZV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX2NhdGVnb3J5XVwiXSxzZWxlY3RbaWQqPVwiW2Nhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllc11cIl0nLCBjYXNlNCA9ICdzZWxlY3RbaWQqPVwiW2FpZF90eXBlX2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19jYXRlZ29yeV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX21vZGFsaXR5XVwiXSc7XHJcbiAgICAgICAgc3dpdGNoICh2YWx1ZSkge1xyXG4gICAgICAgICAgICBjYXNlICcyJzpcclxuICAgICAgICAgICAgICAgIGluZGV4XHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcclxuICAgICAgICAgICAgICAgICAgICAuZmluZChlYXJtYXJraW5nX2NhdGVnb3J5KVxyXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcclxuICAgICAgICAgICAgICAgIGluZGV4XHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcclxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMilcclxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxyXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcclxuICAgICAgICAgICAgICAgIGJyZWFrO1xyXG4gICAgICAgICAgICBjYXNlICczJzpcclxuICAgICAgICAgICAgICAgIGluZGV4XHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcclxuICAgICAgICAgICAgICAgICAgICAuZmluZChlYXJtYXJraW5nX21vZGFsaXR5KVxyXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcclxuICAgICAgICAgICAgICAgIGluZGV4XHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcclxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMylcclxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxyXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcclxuICAgICAgICAgICAgICAgIGJyZWFrO1xyXG4gICAgICAgICAgICBjYXNlICc0JzpcclxuICAgICAgICAgICAgICAgIGluZGV4XHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcclxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXMpXHJcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcclxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xyXG4gICAgICAgICAgICAgICAgaW5kZXhcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U0KVxyXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXHJcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXHJcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcclxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xyXG4gICAgICAgICAgICAgICAgYnJlYWs7XHJcbiAgICAgICAgICAgIGRlZmF1bHQ6XHJcbiAgICAgICAgICAgICAgICBpbmRleFxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoYWlkX3R5cGUpXHJcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcclxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xyXG4gICAgICAgICAgICAgICAgaW5kZXhcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxKVxyXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXHJcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXHJcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcclxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xyXG4gICAgICAgIH1cclxuICAgIH07XHJcbiAgICAvKipcclxuICAgICAqIFBvbGljeSBNYXJrZXIgRm9ybSBQYWdlXHJcbiAgICAgKlxyXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgYW5kIGNvZGVzIGZpZWxkIGJhc2VkIG9uICdAdm9jYWJ1bGFyeScgZmllbGQgdmFsdWVcclxuICAgICAqL1xyXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5wb2xpY3lWb2NhYnVsYXJ5SGlkZUZpZWxkID0gZnVuY3Rpb24gKCkge1xyXG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XHJcbiAgICAgICAgdmFyIHBvbGljeW1ha2VyX3ZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdFtpZCo9XCJwb2xpY3lfbWFya2VyX3ZvY2FidWxhcnlcIl0nKTtcclxuICAgICAgICBpZiAocG9saWN5bWFrZXJfdm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XHJcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuZWFjaChwb2xpY3ltYWtlcl92b2NhYnVsYXJ5LCBmdW5jdGlvbiAoaW5kZXgsIHBvbGljeV9tYXJrZXIpIHtcclxuICAgICAgICAgICAgICAgIHZhciBfYTtcclxuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHBvbGljeV9tYXJrZXIpLnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnMSc7XHJcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlUG9saWN5TWFrZXJGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkocG9saWN5X21hcmtlciksIGRhdGEudG9TdHJpbmcoKSk7XHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICBwb2xpY3ltYWtlcl92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOnNlbGVjdCcsIGZ1bmN0aW9uIChlKSB7XHJcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IGUucGFyYW1zLmRhdGEuaWQ7XHJcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XHJcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlUG9saWN5TWFrZXJGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgZGF0YSk7XHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICBwb2xpY3ltYWtlcl92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKGUpIHtcclxuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcclxuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVQb2xpY3lNYWtlckZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCAnMScpO1xyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICB9XHJcbiAgICB9O1xyXG4gICAgLyoqXHJcbiAgICAgKiBIaWRlcyBQb2xpY3kgTWFya2VyIEZvcm0gRmllbGRzXHJcbiAgICAgKi9cclxuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaGlkZVBvbGljeU1ha2VyRmllbGQgPSBmdW5jdGlvbiAoaW5kZXgsIHZhbHVlKSB7XHJcbiAgICAgICAgdmFyIGNhc2UxX3Nob3cgPSAnc2VsZWN0W2lkKj1cIltwb2xpY3lfbWFya2VyXVwiXScsIGNhc2UyX3Nob3cgPSAnaW5wdXRbaWQqPVwiW3BvbGljeV9tYXJrZXJfdGV4dF1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXScsIGNhc2UxID0gJ2lucHV0W2lkKj1cIltwb2xpY3lfbWFya2VyX3RleHRdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0nLCBjYXNlMiA9ICdzZWxlY3RbaWQqPVwiW3BvbGljeV9tYXJrZXJdXCJdJztcclxuICAgICAgICBzd2l0Y2ggKHZhbHVlKSB7XHJcbiAgICAgICAgICAgIGNhc2UgJzEnOlxyXG4gICAgICAgICAgICAgICAgaW5kZXhcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxX3Nob3cpXHJcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcclxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xyXG4gICAgICAgICAgICAgICAgaW5kZXhcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxKVxyXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXHJcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXHJcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcclxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xyXG4gICAgICAgICAgICAgICAgYnJlYWs7XHJcbiAgICAgICAgICAgIGNhc2UgJzk5JzpcclxuICAgICAgICAgICAgICAgIGluZGV4XHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcclxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMl9zaG93KVxyXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcclxuICAgICAgICAgICAgICAgIGluZGV4XHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcclxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMilcclxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxyXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcclxuICAgICAgICAgICAgICAgIGJyZWFrO1xyXG4gICAgICAgICAgICBkZWZhdWx0OlxyXG4gICAgICAgICAgICAgICAgaW5kZXhcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxX3Nob3cpXHJcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcclxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xyXG4gICAgICAgICAgICAgICAgaW5kZXhcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxKVxyXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXHJcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXHJcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcclxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xyXG4gICAgICAgIH1cclxuICAgIH07XHJcbiAgICAvKipcclxuICAgICAqIFNlY3RvciBGb3JtIFBhZ2VcclxuICAgICAqXHJcbiAgICAgKiBATG9naWMgaGlkZSB2b2NhYnVsYXJ5LXVyaSBhbmQgY29kZXMgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxyXG4gICAgICovXHJcbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLnNlY3RvclZvY2FidWxhcnlIaWRlRmllbGQgPSBmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcclxuICAgICAgICB2YXIgc2VjdG9yX3ZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdFtpZCo9XCJzZWN0b3Jfdm9jYWJ1bGFyeVwiXScpO1xyXG4gICAgICAgIGlmIChzZWN0b3Jfdm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XHJcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuZWFjaChzZWN0b3Jfdm9jYWJ1bGFyeSwgZnVuY3Rpb24gKGluZGV4LCBzZWN0b3IpIHtcclxuICAgICAgICAgICAgICAgIHZhciBfYTtcclxuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHNlY3RvcikudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcxJztcclxuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVTZWN0b3JGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoc2VjdG9yKSwgZGF0YS50b1N0cmluZygpKTtcclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgIHNlY3Rvcl92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOnNlbGVjdCcsIGZ1bmN0aW9uIChlKSB7XHJcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IGUucGFyYW1zLmRhdGEuaWQ7XHJcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XHJcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlU2VjdG9yRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksIGRhdGEpO1xyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgc2VjdG9yX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6Y2xlYXInLCBmdW5jdGlvbiAoZSkge1xyXG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xyXG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVNlY3RvckZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCAnMScpO1xyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICB9XHJcbiAgICB9O1xyXG4gICAgLyoqXHJcbiAgICAgKiBIaWRlIFNlY3RvciBGb3JtIGZpZWxkc1xyXG4gICAgICovXHJcbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmhpZGVTZWN0b3JGaWVsZCA9IGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcclxuICAgICAgICB2YXIgY2FzZTFfc2hvdyA9ICdzZWxlY3RbaWQqPVwiW2NvZGVdXCJdJywgY2FzZTJfc2hvdyA9ICdzZWxlY3RbaWQqPVwiW2NhdGVnb3J5X2NvZGVdXCJdJywgY2FzZTdfc2hvdyA9ICdzZWxlY3RbaWQqPVwiW3NkZ19nb2FsXVwiXScsIGNhc2U4X3Nob3cgPSAnc2VsZWN0W2lkKj1cIltzZGdfdGFyZ2V0XVwiXScsIGNhc2U5OF85OV9zaG93ID0gJ2lucHV0W2lkKj1cIlt0ZXh0XVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdJywgZGVmYXVsdF9zaG93ID0gJ2lucHV0W2lkKj1cIlt0ZXh0XVwiXScsIGNhc2UxID0gJ3NlbGVjdFtpZCo9XCJbY2F0ZWdvcnlfY29kZV1cIl0sc2VsZWN0W2lkKj1cIltzZGdfZ29hbF1cIl0sc2VsZWN0W2lkKj1cIltzZGdfdGFyZ2V0XVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdLGlucHV0W2lkKj1cIlt0ZXh0XVwiXScsIGNhc2UyID0gJ2lucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0sc2VsZWN0W2lkKj1cIltzZGdfZ29hbF1cIl0sc2VsZWN0W2lkKj1cIltzZGdfdGFyZ2V0XVwiXSxzZWxlY3RbaWQqPVwiW2NvZGVdXCJdLGlucHV0W2lkKj1cIlt0ZXh0XVwiXScsIGNhc2U3ID0gJ2lucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0sc2VsZWN0W2lkKj1cIltjYXRlZ29yeV9jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ190YXJnZXRdXCJdLHNlbGVjdFtpZCo9XCJbY29kZV1cIl0saW5wdXRbaWQqPVwiW3RleHRdXCJdJywgY2FzZTggPSAnaW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSxzZWxlY3RbaWQqPVwiW2NhdGVnb3J5X2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX2dvYWxdXCJdLHNlbGVjdFtpZCo9XCJbY29kZV1cIl0saW5wdXRbaWQqPVwiW3RleHRdXCJdJywgY2FzZTk4Xzk5ID0gJ3NlbGVjdFtpZCo9XCJbY2F0ZWdvcnlfY29kZV1cIl0sc2VsZWN0W2lkKj1cIltzZGdfZ29hbF1cIl0sc2VsZWN0W2lkKj1cIltzZGdfdGFyZ2V0XVwiXSxzZWxlY3RbaWQqPVwiW2NvZGVdXCJdJywgZGVmYXVsdF9oaWRlID0gJ3NlbGVjdFtpZCo9XCJbY2F0ZWdvcnlfY29kZV1cIl0sc2VsZWN0W2lkKj1cIltzZGdfZ29hbF1cIl0sc2VsZWN0W2lkKj1cIltzZGdfdGFyZ2V0XVwiXSxzZWxlY3RbaWQqPVwiW2NvZGVdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0nO1xyXG4gICAgICAgIHN3aXRjaCAodmFsdWUpIHtcclxuICAgICAgICAgICAgY2FzZSAnMSc6XHJcbiAgICAgICAgICAgICAgICBpbmRleFxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTFfc2hvdylcclxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XHJcbiAgICAgICAgICAgICAgICBpbmRleFxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTEpXHJcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcclxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcclxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XHJcbiAgICAgICAgICAgICAgICBicmVhaztcclxuICAgICAgICAgICAgY2FzZSAnMic6XHJcbiAgICAgICAgICAgICAgICBpbmRleFxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTJfc2hvdylcclxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XHJcbiAgICAgICAgICAgICAgICBpbmRleFxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTIpXHJcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcclxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcclxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XHJcbiAgICAgICAgICAgICAgICBicmVhaztcclxuICAgICAgICAgICAgY2FzZSAnNyc6XHJcbiAgICAgICAgICAgICAgICBpbmRleFxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTdfc2hvdylcclxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XHJcbiAgICAgICAgICAgICAgICBpbmRleFxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTcpXHJcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcclxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcclxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XHJcbiAgICAgICAgICAgICAgICBicmVhaztcclxuICAgICAgICAgICAgY2FzZSAnOCc6XHJcbiAgICAgICAgICAgICAgICBpbmRleFxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZThfc2hvdylcclxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XHJcbiAgICAgICAgICAgICAgICBpbmRleFxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTgpXHJcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcclxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcclxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XHJcbiAgICAgICAgICAgICAgICBicmVhaztcclxuICAgICAgICAgICAgY2FzZSAnOTgnOlxyXG4gICAgICAgICAgICAgICAgaW5kZXhcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U5OF85OV9zaG93KVxyXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcclxuICAgICAgICAgICAgICAgIGluZGV4XHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcclxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOThfOTkpXHJcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcclxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcclxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XHJcbiAgICAgICAgICAgICAgICBicmVhaztcclxuICAgICAgICAgICAgY2FzZSAnOTknOlxyXG4gICAgICAgICAgICAgICAgaW5kZXhcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U5OF85OV9zaG93KVxyXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcclxuICAgICAgICAgICAgICAgIGluZGV4XHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcclxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOThfOTkpXHJcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcclxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcclxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XHJcbiAgICAgICAgICAgICAgICBicmVhaztcclxuICAgICAgICAgICAgZGVmYXVsdDpcclxuICAgICAgICAgICAgICAgIGluZGV4XHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcclxuICAgICAgICAgICAgICAgICAgICAuZmluZChkZWZhdWx0X3Nob3cpXHJcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcclxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xyXG4gICAgICAgICAgICAgICAgaW5kZXhcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGRlZmF1bHRfaGlkZSlcclxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxyXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcclxuICAgICAgICB9XHJcbiAgICB9O1xyXG4gICAgLyoqXHJcbiAgICAgKiAgUmVjaXBpZW50IFZvY2FidWxhcnkgRm9ybSBQYWdlXHJcbiAgICAgKlxyXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgYW5kIGNvZGVzIGZpZWxkIGJhc2VkIG9uICdAdm9jYWJ1bGFyeScgZmllbGQgdmFsdWVcclxuICAgICAqL1xyXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5yZWNpcGllbnRWb2NhYnVsYXJ5SGlkZUZpZWxkID0gZnVuY3Rpb24gKCkge1xyXG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XHJcbiAgICAgICAgdmFyIHJlZ2lvbl92b2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3RbaWQqPVwicmVnaW9uX3ZvY2FidWxhcnlcIl0nKTtcclxuICAgICAgICBpZiAocmVnaW9uX3ZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xyXG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2gocmVnaW9uX3ZvY2FidWxhcnksIGZ1bmN0aW9uIChpbmRleCwgcmVnaW9uX3ZvY2FiKSB7XHJcbiAgICAgICAgICAgICAgICB2YXIgX2E7XHJcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShyZWdpb25fdm9jYWIpLnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnMSc7XHJcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlUmVjaXBpZW50UmVnaW9uRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHJlZ2lvbl92b2NhYiksIGRhdGEudG9TdHJpbmcoKSk7XHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICByZWdpb25fdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpzZWxlY3QnLCBmdW5jdGlvbiAoZSkge1xyXG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSBlLnBhcmFtcy5kYXRhLmlkO1xyXG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xyXG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVJlY2lwaWVudFJlZ2lvbkZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCBkYXRhKTtcclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgIHJlZ2lvbl92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKGUpIHtcclxuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcclxuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVSZWNpcGllbnRSZWdpb25GaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgJzEnKTtcclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgfVxyXG4gICAgfTtcclxuICAgIC8qKlxyXG4gICAgICogSGlkZXMgUmVjaXBpZW50IFJlZ2lvbiBGb3JtIEZpZWxkc1xyXG4gICAgICovXHJcbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmhpZGVSZWNpcGllbnRSZWdpb25GaWVsZCA9IGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcclxuICAgICAgICB2YXIgY2FzZTFfc2hvdyA9ICdzZWxlY3RbaWQqPVwiW3JlZ2lvbl9jb2RlXVwiXScsIGNhc2UyX3Nob3cgPSAnaW5wdXRbaWQqPVwiW2N1c3RvbV9jb2RlXVwiXSwgaW5wdXRbaWQqPVwiW2NvZGVdXCJdJywgY2FzZTk5X3Nob3cgPSAnaW5wdXRbaWQqPVwiW2N1c3RvbV9jb2RlXVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdLCBpbnB1dFtpZCo9XCJbY29kZV1cIl0nLCBjYXNlMSA9ICdpbnB1dFtpZCo9XCJbY3VzdG9tX2NvZGVdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0saW5wdXRbaWQqPVwiW2NvZGVdXCJdJywgY2FzZTIgPSAnc2VsZWN0W2lkKj1cIltyZWdpb25fY29kZV1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXScsIGNhc2U5OSA9ICdzZWxlY3RbaWQqPVwiW3JlZ2lvbl9jb2RlXVwiXSc7XHJcbiAgICAgICAgc3dpdGNoICh2YWx1ZSkge1xyXG4gICAgICAgICAgICBjYXNlICcxJzpcclxuICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKGNhc2UxX3Nob3cpO1xyXG4gICAgICAgICAgICAgICAgaW5kZXhcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxX3Nob3cpXHJcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcclxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xyXG4gICAgICAgICAgICAgICAgaW5kZXhcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxKVxyXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXHJcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXHJcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcclxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xyXG4gICAgICAgICAgICAgICAgYnJlYWs7XHJcbiAgICAgICAgICAgIGNhc2UgJzInOlxyXG4gICAgICAgICAgICAgICAgaW5kZXhcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyX3Nob3cpXHJcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcclxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xyXG4gICAgICAgICAgICAgICAgaW5kZXhcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyKVxyXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXHJcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXHJcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcclxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xyXG4gICAgICAgICAgICAgICAgYnJlYWs7XHJcbiAgICAgICAgICAgIGNhc2UgJzk5JzpcclxuICAgICAgICAgICAgICAgIGluZGV4XHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcclxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOTlfc2hvdylcclxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XHJcbiAgICAgICAgICAgICAgICBpbmRleFxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTk5KVxyXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXHJcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXHJcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcclxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xyXG4gICAgICAgICAgICAgICAgYnJlYWs7XHJcbiAgICAgICAgICAgIGRlZmF1bHQ6XHJcbiAgICAgICAgICAgICAgICBpbmRleFxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTJfc2hvdylcclxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XHJcbiAgICAgICAgICAgICAgICBpbmRleFxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTIpXHJcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcclxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcclxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XHJcbiAgICAgICAgfVxyXG4gICAgfTtcclxuICAgIC8qKlxyXG4gICAgICogVXBkYXRlcyBBY3Rpdml0eSBpZGVudGlmaWVyXHJcbiAgICAgKi9cclxuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUudXBkYXRlQWN0aXZpdHlJZGVudGlmaWVyID0gZnVuY3Rpb24gKCkge1xyXG4gICAgICAgIHZhciBhY3Rpdml0eV9pZGVudGlmaWVyID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjYWN0aXZpdHlfaWRlbnRpZmllcicpO1xyXG4gICAgICAgIGlmIChhY3Rpdml0eV9pZGVudGlmaWVyLmxlbmd0aCA+IDApIHtcclxuICAgICAgICAgICAgYWN0aXZpdHlfaWRlbnRpZmllci5vbigna2V5dXAnLCBmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNpYXRpX2lkZW50aWZpZXJfdGV4dCcpLnZhbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5pZGVudGlmaWVyJykuYXR0cignYWN0aXZpdHlfaWRlbnRpZmllcicpICsgXCItXCIuY29uY2F0KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS52YWwoKSkpO1xyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICB9XHJcbiAgICB9O1xyXG4gICAgLyoqXHJcbiAgICAgKiBUYWcgRm9ybSBQYWdlXHJcbiAgICAgKlxyXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgYW5kIGNvZGVzIGZpZWxkIGJhc2VkIG9uICdAdm9jYWJ1bGFyeScgZmllbGQgdmFsdWVcclxuICAgICAqL1xyXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS50YWdWb2NhYnVsYXJ5SGlkZUZpZWxkID0gZnVuY3Rpb24gKCkge1xyXG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XHJcbiAgICAgICAgdmFyIHRhZ192b2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3RbaWQqPVwidGFnX3ZvY2FidWxhcnlcIl0nKTtcclxuICAgICAgICBpZiAodGFnX3ZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xyXG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2godGFnX3ZvY2FidWxhcnksIGZ1bmN0aW9uIChpbmRleCwgdGFnKSB7XHJcbiAgICAgICAgICAgICAgICB2YXIgX2E7XHJcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YWcpLnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnMSc7XHJcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlVGFnRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhZyksIGRhdGEudG9TdHJpbmcoKSk7XHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICB0YWdfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpzZWxlY3QnLCBmdW5jdGlvbiAoZSkge1xyXG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSBlLnBhcmFtcy5kYXRhLmlkO1xyXG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xyXG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVRhZ0ZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCBkYXRhKTtcclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgIHRhZ192b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKGUpIHtcclxuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcclxuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVUYWdGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgJzEnKTtcclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgfVxyXG4gICAgfTtcclxuICAgIC8qKlxyXG4gICAgICogSGlkZSBUYWcgRm9ybSBmaWVsZHNcclxuICAgICAqL1xyXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5oaWRlVGFnRmllbGQgPSBmdW5jdGlvbiAoaW5kZXgsIHZhbHVlKSB7XHJcbiAgICAgICAgdmFyIGNhc2UxX3Nob3cgPSAnaW5wdXRbaWQqPVwiW3RhZ190ZXh0XVwiXScsIGNhc2UyX3Nob3cgPSAnc2VsZWN0W2lkKj1cIltnb2Fsc190YWdfY29kZV1cIl0nLCBjYXNlM19zaG93ID0gJ3NlbGVjdFtpZCo9XCJbdGFyZ2V0c190YWdfY29kZV1cIl0nLCBjYXNlOTlfc2hvdyA9ICdpbnB1dFtpZCo9XCJbdGFnX3RleHRdXCJdLCBpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdJywgY2FzZTEgPSAnc2VsZWN0W2lkKj1cIltnb2Fsc190YWdfY29kZV1cIl0sc2VsZWN0W2lkKj1cIlt0YXJnZXRzX3RhZ19jb2RlXVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdJywgY2FzZTIgPSAnaW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSxzZWxlY3RbaWQqPVwiW3RhcmdldHNfdGFnX2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbdGFyZ2V0c190YWdfY29kZV1cIl0saW5wdXRbaWQqPVwiW3RhZ190ZXh0XVwiXScsIGNhc2UzID0gJ2lucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0sc2VsZWN0W2lkKj1cIltnb2Fsc190YWdfY29kZV1cIl0saW5wdXRbaWQqPVwiW3RhZ190ZXh0XVwiXScsIGNhc2U5OSA9ICdzZWxlY3RbaWQqPVwiW2dvYWxzX3RhZ19jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW3RhcmdldHNfdGFnX2NvZGVdXCJdJztcclxuICAgICAgICBzd2l0Y2ggKHZhbHVlKSB7XHJcbiAgICAgICAgICAgIGNhc2UgJzEnOlxyXG4gICAgICAgICAgICAgICAgaW5kZXhcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxX3Nob3cpXHJcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcclxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xyXG4gICAgICAgICAgICAgICAgaW5kZXhcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxKVxyXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXHJcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXHJcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcclxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xyXG4gICAgICAgICAgICAgICAgYnJlYWs7XHJcbiAgICAgICAgICAgIGNhc2UgJzInOlxyXG4gICAgICAgICAgICAgICAgaW5kZXhcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyX3Nob3cpXHJcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcclxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xyXG4gICAgICAgICAgICAgICAgaW5kZXhcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyKVxyXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXHJcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXHJcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcclxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xyXG4gICAgICAgICAgICAgICAgYnJlYWs7XHJcbiAgICAgICAgICAgIGNhc2UgJzMnOlxyXG4gICAgICAgICAgICAgICAgaW5kZXhcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UzX3Nob3cpXHJcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcclxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xyXG4gICAgICAgICAgICAgICAgaW5kZXhcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UzKVxyXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXHJcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXHJcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcclxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xyXG4gICAgICAgICAgICAgICAgYnJlYWs7XHJcbiAgICAgICAgICAgIGNhc2UgJzk5JzpcclxuICAgICAgICAgICAgICAgIGluZGV4XHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcclxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOTlfc2hvdylcclxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XHJcbiAgICAgICAgICAgICAgICBpbmRleFxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTk5KVxyXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXHJcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXHJcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcclxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xyXG4gICAgICAgICAgICAgICAgYnJlYWs7XHJcbiAgICAgICAgICAgIGRlZmF1bHQ6XHJcbiAgICAgICAgICAgICAgICBpbmRleFxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTFfc2hvdylcclxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XHJcbiAgICAgICAgICAgICAgICBpbmRleFxyXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXHJcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTEpXHJcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcclxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcclxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcclxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxyXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XHJcbiAgICAgICAgfVxyXG4gICAgfTtcclxuICAgIHJldHVybiBEeW5hbWljRmllbGQ7XHJcbn0oKSk7XHJcbmV4cG9ydHMuRHluYW1pY0ZpZWxkID0gRHluYW1pY0ZpZWxkO1xyXG4iLCJcInVzZSBzdHJpY3RcIjtcclxudmFyIF9faW1wb3J0RGVmYXVsdCA9ICh0aGlzICYmIHRoaXMuX19pbXBvcnREZWZhdWx0KSB8fCBmdW5jdGlvbiAobW9kKSB7XHJcbiAgICByZXR1cm4gKG1vZCAmJiBtb2QuX19lc01vZHVsZSkgPyBtb2QgOiB7IFwiZGVmYXVsdFwiOiBtb2QgfTtcclxufTtcclxuT2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFwiX19lc01vZHVsZVwiLCB7IHZhbHVlOiB0cnVlIH0pO1xyXG52YXIganF1ZXJ5XzEgPSBfX2ltcG9ydERlZmF1bHQocmVxdWlyZShcImpxdWVyeVwiKSk7XHJcbnJlcXVpcmUoXCJzZWxlY3QyXCIpO1xyXG52YXIgRHluYW1pY0ZpZWxkXzEgPSByZXF1aXJlKFwiLi9EeW5hbWljRmllbGRcIik7XHJcbnZhciBkeW5hbWljRmllbGQgPSBuZXcgRHluYW1pY0ZpZWxkXzEuRHluYW1pY0ZpZWxkKCk7XHJcbnZhciBGb3JtQnVpbGRlciA9IC8qKiBAY2xhc3MgKi8gKGZ1bmN0aW9uICgpIHtcclxuICAgIGZ1bmN0aW9uIEZvcm1CdWlsZGVyKCkge1xyXG4gICAgfVxyXG4gICAgLy8gYWRkcyBuZXcgY29sbGVjdGlvbiBvZiBzdWItZWxlbWVudFxyXG4gICAgRm9ybUJ1aWxkZXIucHJvdG90eXBlLmFkZEZvcm0gPSBmdW5jdGlvbiAoZXYpIHtcclxuICAgICAgICBldi5wcmV2ZW50RGVmYXVsdCgpO1xyXG4gICAgICAgIHZhciB0YXJnZXQgPSBldi50YXJnZXQ7XHJcbiAgICAgICAgdmFyIGNvbnRhaW5lciA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2Zvcm1fdHlwZScpXHJcbiAgICAgICAgICAgID8gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKFwiLmNvbGxlY3Rpb24tY29udGFpbmVyW2Zvcm1fdHlwZSA9J1wiLmNvbmNhdCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdmb3JtX3R5cGUnKSwgXCInXVwiKSlcclxuICAgICAgICAgICAgOiAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5jb2xsZWN0aW9uLWNvbnRhaW5lcicpO1xyXG4gICAgICAgIHZhciBjb3VudCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2NoaWxkX2NvdW50JylcclxuICAgICAgICAgICAgPyBwYXJzZUludCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdjaGlsZF9jb3VudCcpKSArIDFcclxuICAgICAgICAgICAgOiAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wYXJlbnQoKS5maW5kKCcuZm9ybS1jaGlsZC1ib2R5JykubGVuZ3RoO1xyXG4gICAgICAgIHZhciBwYXJlbnRfY291bnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdwYXJlbnRfY291bnQnKVxyXG4gICAgICAgICAgICA/IHBhcnNlSW50KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ3BhcmVudF9jb3VudCcpKVxyXG4gICAgICAgICAgICA6ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLnBhcmVudCgnLnN1YmVsZW1lbnQnKS5wcmV2QWxsKCcubXVsdGktZm9ybScpLmxlbmd0aDtcclxuICAgICAgICB2YXIgd3JhcHBlcl9wYXJlbnRfY291bnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCd3cmFwcGVkX3BhcmVudF9jb3VudCcpXHJcbiAgICAgICAgICAgID8gcGFyc2VJbnQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignd3JhcHBlZF9wYXJlbnRfY291bnQnKSlcclxuICAgICAgICAgICAgOiAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wYXJlbnQoJy5zdWJlbGVtZW50JykuZmluZCgnLndyYXBwZWQtY2hpbGQtYm9keScpLmxlbmd0aDtcclxuICAgICAgICB2YXIgcHJvdG8gPSBjb250YWluZXJcclxuICAgICAgICAgICAgLmRhdGEoJ3Byb3RvdHlwZScpXHJcbiAgICAgICAgICAgIC5yZXBsYWNlKC9fX1BBUkVOVF9OQU1FX18vZywgcGFyZW50X2NvdW50KTtcclxuICAgICAgICBpZiAoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignaGFzX2NoaWxkX2NvbGxlY3Rpb24nKSkge1xyXG4gICAgICAgICAgICBwcm90byA9IHByb3RvLnJlcGxhY2UoL19fV1JBUFBFUl9OQU1FX18vZywgY291bnQpO1xyXG4gICAgICAgICAgICBwcm90byA9IHByb3RvLnJlcGxhY2UoL19fTkFNRV9fL2csIDApO1xyXG4gICAgICAgIH1cclxuICAgICAgICBlbHNlIHtcclxuICAgICAgICAgICAgcHJvdG8gPSBwcm90by5yZXBsYWNlKC9fX05BTUVfXy9nLCBjb3VudCk7XHJcbiAgICAgICAgICAgIHByb3RvID0gcHJvdG8ucmVwbGFjZSgvX19XUkFQUEVSX05BTUVfXy9nLCB3cmFwcGVyX3BhcmVudF9jb3VudCk7XHJcbiAgICAgICAgfVxyXG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLnByZXYoKS5hcHBlbmQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHByb3RvKSk7XHJcbiAgICAgICAgaWYgKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2hhc19jaGlsZF9jb2xsZWN0aW9uJykpIHtcclxuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldClcclxuICAgICAgICAgICAgICAgIC5wcmV2KCcuc3ViZWxlbWVudCcpXHJcbiAgICAgICAgICAgICAgICAuY2hpbGRyZW4oJy53cmFwcGVkLWNoaWxkLWJvZHknKVxyXG4gICAgICAgICAgICAgICAgLmxhc3QoKVxyXG4gICAgICAgICAgICAgICAgLmZpbmQoJy5hZGRfdG9fY29sbGVjdGlvbicpXHJcbiAgICAgICAgICAgICAgICAuYXR0cignd3JhcHBlZF9wYXJlbnRfY291bnQnLCBjb3VudCk7XHJcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXHJcbiAgICAgICAgICAgICAgICAucHJldignLnN1YmVsZW1lbnQnKVxyXG4gICAgICAgICAgICAgICAgLmNoaWxkcmVuKCcud3JhcHBlZC1jaGlsZC1ib2R5JylcclxuICAgICAgICAgICAgICAgIC5sYXN0KClcclxuICAgICAgICAgICAgICAgIC5maW5kKCcuYWRkX3RvX2NvbGxlY3Rpb24nKVxyXG4gICAgICAgICAgICAgICAgLmF0dHIoJ3BhcmVudF9jb3VudCcsIHBhcmVudF9jb3VudCk7XHJcbiAgICAgICAgfVxyXG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXHJcbiAgICAgICAgICAgIC5wcmV2KClcclxuICAgICAgICAgICAgLmZpbmQoJy53cmFwcGVkLWNoaWxkLWJvZHknKVxyXG4gICAgICAgICAgICAubGFzdCgpXHJcbiAgICAgICAgICAgIC5maW5kKCcuYWRkX3RvX2NvbGxlY3Rpb24nKVxyXG4gICAgICAgICAgICAuYXR0cignd3JhcHBlcl9wYXJlbnRfY291bnQnLCB3cmFwcGVyX3BhcmVudF9jb3VudCAhPT0gbnVsbCAmJiB3cmFwcGVyX3BhcmVudF9jb3VudCAhPT0gdm9pZCAwID8gd3JhcHBlcl9wYXJlbnRfY291bnQgOiAwKTtcclxuICAgICAgICBpZiAoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignZm9ybV90eXBlJykpIHtcclxuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucHJldigpLmxhc3QoKS5maW5kKCcuc2VsZWN0MicpLnNlbGVjdDIoe1xyXG4gICAgICAgICAgICAgICAgcGxhY2Vob2xkZXI6ICdTZWxlY3QgYW4gb3B0aW9uJyxcclxuICAgICAgICAgICAgICAgIGFsbG93Q2xlYXI6IHRydWUsXHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcclxuICAgICAgICAgICAgICAgIC5maW5kKCcuc3ViLWF0dHJpYnV0ZScpXHJcbiAgICAgICAgICAgICAgICAud3JhcEFsbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJzxkaXYgY2xhc3M9XCJmb3JtLWZpZWxkLWdyb3VwIGZsZXggZmxleC13cmFwIHJvdW5kZWQtYnItbGcgYm9yZGVyLXkgYm9yZGVyLXIgYm9yZGVyLXNwcmluZy01MCBzdWItYXR0cmlidXRlLXdyYXBwZXJcIj48L2Rpdj4nKSk7XHJcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXHJcbiAgICAgICAgICAgICAgICAucHJldignLnN1YmVsZW1lbnQnKVxyXG4gICAgICAgICAgICAgICAgLmNoaWxkcmVuKCcud3JhcHBlZC1jaGlsZC1ib2R5JylcclxuICAgICAgICAgICAgICAgIC5sYXN0KClcclxuICAgICAgICAgICAgICAgIC5maW5kKCcuc3ViLWF0dHJpYnV0ZScpXHJcbiAgICAgICAgICAgICAgICAud3JhcEFsbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJzxkaXYgY2xhc3M9XCJmb3JtLWZpZWxkLWdyb3VwIGZsZXggZmxleC13cmFwIHJvdW5kZWQtYnItbGcgYm9yZGVyLXkgYm9yZGVyLXIgYm9yZGVyLXNwcmluZy01MCBzdWItYXR0cmlidXRlLXdyYXBwZXIgbXQtNlwiPjwvZGl2PicpKTtcclxuICAgICAgICB9XHJcbiAgICAgICAgZWxzZSB7XHJcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXHJcbiAgICAgICAgICAgICAgICAucGFyZW50KClcclxuICAgICAgICAgICAgICAgIC5maW5kKCcuZm9ybS1jaGlsZC1ib2R5JylcclxuICAgICAgICAgICAgICAgIC5sYXN0KClcclxuICAgICAgICAgICAgICAgIC5maW5kKCcuc2VsZWN0MicpXHJcbiAgICAgICAgICAgICAgICAuc2VsZWN0Mih7XHJcbiAgICAgICAgICAgICAgICBwbGFjZWhvbGRlcjogJ1NlbGVjdCBhbiBvcHRpb24nLFxyXG4gICAgICAgICAgICAgICAgYWxsb3dDbGVhcjogdHJ1ZSxcclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgfVxyXG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2NoaWxkX2NvdW50JywgY291bnQpO1xyXG4gICAgICAgIGR5bmFtaWNGaWVsZC5haWRUeXBlVm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xyXG4gICAgICAgIGR5bmFtaWNGaWVsZC5zZWN0b3JWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XHJcbiAgICB9O1xyXG4gICAgLy8gYWRkcyBwYXJlbnQgY29sbGVjdGlvblxyXG4gICAgRm9ybUJ1aWxkZXIucHJvdG90eXBlLmFkZFBhcmVudEZvcm0gPSBmdW5jdGlvbiAoZXYpIHtcclxuICAgICAgICBldi5wcmV2ZW50RGVmYXVsdCgpO1xyXG4gICAgICAgIHZhciB0YXJnZXQgPSBldi50YXJnZXQ7XHJcbiAgICAgICAgdmFyIGNvbnRhaW5lciA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2Zvcm1fdHlwZScpXHJcbiAgICAgICAgICAgID8gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKFwiLnBhcmVudC1jb2xsZWN0aW9uW2Zvcm1fdHlwZSA9J1wiLmNvbmNhdCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdmb3JtX3R5cGUnKSwgXCInXVwiKSlcclxuICAgICAgICAgICAgOiAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5wYXJlbnQtY29sbGVjdGlvbicpO1xyXG4gICAgICAgIHZhciBjb3VudCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ3BhcmVudF9jb3VudCcpXHJcbiAgICAgICAgICAgID8gcGFyc2VJbnQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cigncGFyZW50X2NvdW50JykpICsgMVxyXG4gICAgICAgICAgICA6ICgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wcmV2KCkuZmluZCgnLm11bHRpLWZvcm0nKS5sZW5ndGhcclxuICAgICAgICAgICAgICAgID8gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucHJldigpLmZpbmQoJy5tdWx0aS1mb3JtJykubGVuZ3RoXHJcbiAgICAgICAgICAgICAgICA6ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLnByZXYoKS5maW5kKCcud3JhcHBlZC1jaGlsZC1ib2R5JykubGVuZ3RoKSArIDE7XHJcbiAgICAgICAgdmFyIHByb3RvID0gY29udGFpbmVyLmRhdGEoJ3Byb3RvdHlwZScpLnJlcGxhY2UoL19fUEFSRU5UX05BTUVfXy9nLCBjb3VudCk7XHJcbiAgICAgICAgcHJvdG8gPSBwcm90by5yZXBsYWNlKC9fX05BTUVfXy9nLCAwKTtcclxuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wcmV2KCkuYXBwZW5kKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShwcm90bykpO1xyXG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLnByZXYoKS5maW5kKCcubXVsdGktZm9ybScpLmxhc3QoKS5maW5kKCcuc2VsZWN0MicpLnNlbGVjdDIoe1xyXG4gICAgICAgICAgICBwbGFjZWhvbGRlcjogJ1NlbGVjdCBhbiBvcHRpb24nLFxyXG4gICAgICAgICAgICBhbGxvd0NsZWFyOiB0cnVlLFxyXG4gICAgICAgIH0pO1xyXG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXHJcbiAgICAgICAgICAgIC5wcmV2KClcclxuICAgICAgICAgICAgLmZpbmQoJy5tdWx0aS1mb3JtJylcclxuICAgICAgICAgICAgLmxhc3QoKVxyXG4gICAgICAgICAgICAuZmluZCgnLmFkZF90b19jb2xsZWN0aW9uJylcclxuICAgICAgICAgICAgLmF0dHIoJ3BhcmVudF9jb3VudCcsIGNvdW50KTtcclxuICAgICAgICB0aGlzLmFkZFdyYXBwZXJPbkFkZCh0YXJnZXQpO1xyXG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ3BhcmVudF9jb3VudCcsIGNvdW50KTtcclxuICAgICAgICBkeW5hbWljRmllbGQuaHVtYW5pdGFyaWFuU2NvcGVIaWRlVm9jYWJ1bGFyeVVyaSgpO1xyXG4gICAgICAgIGR5bmFtaWNGaWVsZC5jb3VudHJ5QnVkZ2V0SGlkZUNvZGVGaWVsZCgpO1xyXG4gICAgICAgIGR5bmFtaWNGaWVsZC5zZWN0b3JWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XHJcbiAgICAgICAgZHluYW1pY0ZpZWxkLnJlY2lwaWVudFZvY2FidWxhcnlIaWRlRmllbGQoKTtcclxuICAgICAgICBkeW5hbWljRmllbGQucG9saWN5Vm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xyXG4gICAgICAgIGR5bmFtaWNGaWVsZC50YWdWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XHJcbiAgICAgICAgZHluYW1pY0ZpZWxkLnRyYW5zYWN0aW9uQWlkVHlwZVZvY2FidWxhcnlIaWRlRmllbGQoKTtcclxuICAgICAgICBkeW5hbWljRmllbGQuaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkVXJpKCk7XHJcbiAgICB9O1xyXG4gICAgLy8gZGVsZXRlcyBjb2xsZWN0aW9uXHJcbiAgICBGb3JtQnVpbGRlci5wcm90b3R5cGUuZGVsZXRlRm9ybSA9IGZ1bmN0aW9uIChldikge1xyXG4gICAgICAgIGV2LnByZXZlbnREZWZhdWx0KCk7XHJcbiAgICAgICAgdmFyIHRhcmdldCA9IGV2LnRhcmdldDtcclxuICAgICAgICB2YXIgY29sbGVjdGlvbkxlbmd0aCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLm11bHRpLWZvcm0nKS5sZW5ndGhcclxuICAgICAgICAgICAgPyAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5jbG9zZXN0KCcuc3ViZWxlbWVudCcpLmZpbmQoJy5mb3JtLWNoaWxkLWJvZHknKS5sZW5ndGhcclxuICAgICAgICAgICAgOiAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5mb3JtLWNoaWxkLWJvZHknKS5sZW5ndGg7XHJcbiAgICAgICAgdmFyIGNvdW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX2NvbGxlY3Rpb24nKS5hdHRyKCdjaGlsZF9jb3VudCcpXHJcbiAgICAgICAgICAgID8gcGFyc2VJbnQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX2NvbGxlY3Rpb24nKS5hdHRyKCdjaGlsZF9jb3VudCcpKSArIDFcclxuICAgICAgICAgICAgOiBjb2xsZWN0aW9uTGVuZ3RoO1xyXG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmFkZF90b19jb2xsZWN0aW9uJykuYXR0cignY2hpbGRfY291bnQnLCBjb3VudCk7XHJcbiAgICAgICAgaWYgKGNvbGxlY3Rpb25MZW5ndGggPiAxKSB7XHJcbiAgICAgICAgICAgIHZhciB0ZyA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmNsb3Nlc3QoJy5mb3JtLWNoaWxkLWJvZHknKTtcclxuICAgICAgICAgICAgdGcubmV4dCgnLmVycm9yJykucmVtb3ZlKCk7XHJcbiAgICAgICAgICAgIHRnLnJlbW92ZSgpO1xyXG4gICAgICAgIH1cclxuICAgIH07XHJcbiAgICAvLyBkZWxldGVzIHBhcmVudCBjb2xsZWN0aW9uXHJcbiAgICBGb3JtQnVpbGRlci5wcm90b3R5cGUuZGVsZXRlUGFyZW50Rm9ybSA9IGZ1bmN0aW9uIChldikge1xyXG4gICAgICAgIGV2LnByZXZlbnREZWZhdWx0KCk7XHJcbiAgICAgICAgdmFyIHRhcmdldCA9IGV2LnRhcmdldDtcclxuICAgICAgICB2YXIgY29sbGVjdGlvbkxlbmd0aCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLnN1YmVsZW1lbnQnKS5sZW5ndGg7XHJcbiAgICAgICAgdmFyIGNvdW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX3BhcmVudCcpLmF0dHIoJ2NoaWxkX2NvdW50JylcclxuICAgICAgICAgICAgPyBwYXJzZUludCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5hZGRfdG9fcGFyZW50JykuYXR0cignY2hpbGRfY291bnQnKSkgKyAxXHJcbiAgICAgICAgICAgIDogY29sbGVjdGlvbkxlbmd0aDtcclxuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5hZGRfdG9fcGFyZW50JykuYXR0cignY2hpbGRfY291bnQnLCBjb3VudCk7XHJcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX3BhcmVudCcpLmF0dHIoJ3BhcmVudF9jb3VudCcsIGNvdW50KTtcclxuICAgICAgICBpZiAoY29sbGVjdGlvbkxlbmd0aCA+IDIpIHtcclxuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucGFyZW50KCkucmVtb3ZlKCk7XHJcbiAgICAgICAgfVxyXG4gICAgfTtcclxuICAgIC8vYWRkIHdyYXBwZXIgZGl2IGFyb3VuZCB0aGUgYXR0cmlidXRlc1xyXG4gICAgRm9ybUJ1aWxkZXIucHJvdG90eXBlLmFkZFdyYXBwZXIgPSBmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcubXVsdGktZm9ybScpLmVhY2goZnVuY3Rpb24gKCkge1xyXG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcclxuICAgICAgICAgICAgICAgIC5maW5kKCcuYXR0cmlidXRlJylcclxuICAgICAgICAgICAgICAgIC53cmFwQWxsKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnPGRpdiBjbGFzcz1cImZvcm0tZmllbGQtZ3JvdXAgZmxleCBmbGV4LXdyYXAgcm91bmRlZC1ici1sZyBib3JkZXIteSBib3JkZXItciBib3JkZXItc3ByaW5nLTUwIGF0dHJpYnV0ZS13cmFwcGVyIG1iLTRcIj48L2Rpdj4nKSk7XHJcbiAgICAgICAgfSk7XHJcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuc3ViZWxlbWVudCcpXHJcbiAgICAgICAgICAgIC5maW5kKCcud3JhcHBlZC1jaGlsZC1ib2R5JylcclxuICAgICAgICAgICAgLmVhY2goZnVuY3Rpb24gKCkge1xyXG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcclxuICAgICAgICAgICAgICAgIC5maW5kKCcuc3ViLWF0dHJpYnV0ZScpXHJcbiAgICAgICAgICAgICAgICAud3JhcEFsbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJzxkaXYgY2xhc3M9XCJmb3JtLWZpZWxkLWdyb3VwIGZsZXggZmxleC13cmFwIHJvdW5kZWQtYnItbGcgYm9yZGVyLXkgYm9yZGVyLXIgYm9yZGVyLXNwcmluZy01MCBzdWItYXR0cmlidXRlLXdyYXBwZXIgbWItNFwiPjwvZGl2PicpKTtcclxuICAgICAgICB9KTtcclxuICAgICAgICB2YXIgZm9ybUZpZWxkID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdmb3JtPi5mb3JtLWZpZWxkJyk7XHJcbiAgICAgICAgaWYgKGZvcm1GaWVsZC5sZW5ndGggPiAwKSB7XHJcbiAgICAgICAgICAgIGZvcm1GaWVsZC53cmFwQWxsKCc8ZGl2IGNsYXNzPVwiZm9ybS1maWVsZC1ncm91cC1vdXRlciBncmlkIHhsOmdyaWQtY29scy0yIG1iLTYgLW14LTMgZ2FwLXktNlwiPjwvZGl2PicpO1xyXG4gICAgICAgIH1cclxuICAgIH07XHJcbiAgICBGb3JtQnVpbGRlci5wcm90b3R5cGUuYWRkV3JhcHBlck9uQWRkID0gZnVuY3Rpb24gKHRhcmdldCkge1xyXG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXHJcbiAgICAgICAgICAgIC5wcmV2KClcclxuICAgICAgICAgICAgLmZpbmQoJy5tdWx0aS1mb3JtJylcclxuICAgICAgICAgICAgLmxhc3QoKVxyXG4gICAgICAgICAgICAuZmluZCgnLmF0dHJpYnV0ZScpXHJcbiAgICAgICAgICAgIC53cmFwQWxsKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnPGRpdiBjbGFzcz1cImZvcm0tZmllbGQtZ3JvdXAgZ3JpZCB4bDpncmlkLWNvbHMtMiByb3VuZGVkLWJyLWxnIGJvcmRlci15IGJvcmRlci1yIGJvcmRlci1zcHJpbmctNTAgYXR0cmlidXRlLXdyYXBwZXIgbWItNFwiPjwvZGl2PicpKTtcclxuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KVxyXG4gICAgICAgICAgICAucHJldigpXHJcbiAgICAgICAgICAgIC5maW5kKCcubXVsdGktZm9ybScpXHJcbiAgICAgICAgICAgIC5sYXN0KClcclxuICAgICAgICAgICAgLmZpbmQoJy5zdWJlbGVtZW50JylcclxuICAgICAgICAgICAgLmZpbmQoJy53cmFwcGVkLWNoaWxkLWJvZHknKVxyXG4gICAgICAgICAgICAuZWFjaChmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKVxyXG4gICAgICAgICAgICAgICAgLmZpbmQoJy5zdWItYXR0cmlidXRlJylcclxuICAgICAgICAgICAgICAgIC53cmFwQWxsKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnPGRpdiBjbGFzcz1cImZvcm0tZmllbGQtZ3JvdXAgZmxleCBmbGV4LXdyYXAgcm91bmRlZC1ici1sZyBib3JkZXIteSBib3JkZXItciBib3JkZXItc3ByaW5nLTUwIHN1Yi1hdHRyaWJ1dGUtd3JhcHBlciBtYi00XCI+PC9kaXY+JykpO1xyXG4gICAgICAgIH0pO1xyXG4gICAgfTtcclxuICAgIEZvcm1CdWlsZGVyLnByb3RvdHlwZS50ZXh0QXJlYUhlaWdodCA9IGZ1bmN0aW9uIChldikge1xyXG4gICAgICAgIHZhciB0YXJnZXQgPSBldi50YXJnZXQ7XHJcbiAgICAgICAgdmFyIGhlaWdodCA9IHRhcmdldC5zY3JvbGxIZWlnaHQ7XHJcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuY3NzKCdoZWlnaHQnLCBoZWlnaHQpO1xyXG4gICAgfTtcclxuICAgIEZvcm1CdWlsZGVyLnByb3RvdHlwZS5hZGRUb0NvbGxlY3Rpb24gPSBmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcclxuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCAnLmFkZF90b19jb2xsZWN0aW9uJywgZnVuY3Rpb24gKGV2ZW50KSB7XHJcbiAgICAgICAgICAgIF90aGlzLmFkZEZvcm0oZXZlbnQpO1xyXG4gICAgICAgIH0pO1xyXG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmFkZF90b19wYXJlbnQnKS5vbignY2xpY2snLCBmdW5jdGlvbiAoZXZlbnQpIHtcclxuICAgICAgICAgICAgX3RoaXMuYWRkUGFyZW50Rm9ybShldmVudCk7XHJcbiAgICAgICAgfSk7XHJcbiAgICB9O1xyXG4gICAgRm9ybUJ1aWxkZXIucHJvdG90eXBlLmRlbGV0ZUNvbGxlY3Rpb24gPSBmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcclxuICAgICAgICB2YXIgZGVsZXRlQ29uZmlybWF0aW9uID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuZGVsZXRlLWNvbmZpcm1hdGlvbicpLCBjYW5jZWxQb3B1cCA9ICcuY2FuY2VsLXBvcHVwJywgZGVsZXRlQ29uZmlybSA9ICcuZGVsZXRlLWNvbmZpcm0nO1xyXG4gICAgICAgIHZhciBkZWxldGVJbmRleCA9IHt9LCBjaGlsZE9yUGFyZW50ID0gJyc7XHJcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgJy5kZWxldGUnLCBmdW5jdGlvbiAoZXZlbnQpIHtcclxuICAgICAgICAgICAgZGVsZXRlQ29uZmlybWF0aW9uLmZhZGVJbigpO1xyXG4gICAgICAgICAgICBkZWxldGVJbmRleCA9IGV2ZW50O1xyXG4gICAgICAgICAgICBjaGlsZE9yUGFyZW50ID0gJ2NoaWxkJztcclxuICAgICAgICB9KTtcclxuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCBjYW5jZWxQb3B1cCwgZnVuY3Rpb24gKCkge1xyXG4gICAgICAgICAgICBkZWxldGVDb25maXJtYXRpb24uZmFkZU91dCgpO1xyXG4gICAgICAgICAgICBkZWxldGVJbmRleCA9IHt9O1xyXG4gICAgICAgICAgICBjaGlsZE9yUGFyZW50ID0gJyc7XHJcbiAgICAgICAgfSk7XHJcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgZGVsZXRlQ29uZmlybSwgZnVuY3Rpb24gKCkge1xyXG4gICAgICAgICAgICBpZiAoY2hpbGRPclBhcmVudCA9PT0gJ2NoaWxkJykge1xyXG4gICAgICAgICAgICAgICAgX3RoaXMuZGVsZXRlRm9ybShkZWxldGVJbmRleCk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZSBpZiAoY2hpbGRPclBhcmVudCA9PT0gJ3BhcmVudCcpIHtcclxuICAgICAgICAgICAgICAgIF90aGlzLmRlbGV0ZVBhcmVudEZvcm0oZGVsZXRlSW5kZXgpO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGRlbGV0ZUNvbmZpcm1hdGlvbi5mYWRlT3V0KCk7XHJcbiAgICAgICAgICAgIGRlbGV0ZUluZGV4ID0ge307XHJcbiAgICAgICAgICAgIGNoaWxkT3JQYXJlbnQgPSAnJztcclxuICAgICAgICB9KTtcclxuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCAnLmRlbGV0ZS1wYXJlbnQnLCBmdW5jdGlvbiAoZXZlbnQpIHtcclxuICAgICAgICAgICAgZGVsZXRlQ29uZmlybWF0aW9uLmZhZGVJbigpO1xyXG4gICAgICAgICAgICBkZWxldGVJbmRleCA9IGV2ZW50O1xyXG4gICAgICAgICAgICBjaGlsZE9yUGFyZW50ID0gJ3BhcmVudCc7XHJcbiAgICAgICAgfSk7XHJcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuc2VsZWN0MicpLnNlbGVjdDIoe1xyXG4gICAgICAgICAgICBwbGFjZWhvbGRlcjogJ1NlbGVjdCBhbiBvcHRpb24nLFxyXG4gICAgICAgICAgICBhbGxvd0NsZWFyOiB0cnVlLFxyXG4gICAgICAgIH0pO1xyXG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjaGFuZ2UnLCAnaW5wdXRbaWQqPVwiW2RvY3VtZW50XVwiXScsIGZ1bmN0aW9uICgpIHtcclxuICAgICAgICAgICAgdmFyIF9hLCBfYiwgX2M7XHJcbiAgICAgICAgICAgIHZhciBlbmRwb2ludCA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmVuZHBvaW50JykuYXR0cignZW5kcG9pbnQnKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJyc7XHJcbiAgICAgICAgICAgIHZhciBmaWxlX25hbWUgPSAoKF9iID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpLnZhbCgpKSAhPT0gbnVsbCAmJiBfYiAhPT0gdm9pZCAwID8gX2IgOiAnJykudG9TdHJpbmcoKTtcclxuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpXHJcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxyXG4gICAgICAgICAgICAgICAgLmZpbmQoJ2lucHV0W2lkKj1cIlt1cmxdXCJdJylcclxuICAgICAgICAgICAgICAgIC52YWwoXCJcIi5jb25jYXQoZW5kcG9pbnQsIFwiL1wiKS5jb25jYXQoKF9jID0gZmlsZV9uYW1lID09PSBudWxsIHx8IGZpbGVfbmFtZSA9PT0gdm9pZCAwID8gdm9pZCAwIDogZmlsZV9uYW1lLnNwbGl0KCdcXFxcJykucG9wKCkpID09PSBudWxsIHx8IF9jID09PSB2b2lkIDAgPyB2b2lkIDAgOiBfYy5yZXBsYWNlKCcgJywgJ18nKSkpO1xyXG4gICAgICAgIH0pO1xyXG4gICAgfTtcclxuICAgIHJldHVybiBGb3JtQnVpbGRlcjtcclxufSgpKTtcclxuKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGZ1bmN0aW9uICgpIHtcclxuICAgIHZhciBmb3JtQnVpbGRlciA9IG5ldyBGb3JtQnVpbGRlcigpO1xyXG4gICAgZm9ybUJ1aWxkZXIuYWRkV3JhcHBlcigpO1xyXG4gICAgZHluYW1pY0ZpZWxkLmhpZGVTaG93Rm9ybUZpZWxkcygpO1xyXG4gICAgZHluYW1pY0ZpZWxkLnVwZGF0ZUFjdGl2aXR5SWRlbnRpZmllcigpO1xyXG4gICAgZm9ybUJ1aWxkZXIuYWRkVG9Db2xsZWN0aW9uKCk7XHJcbiAgICBmb3JtQnVpbGRlci5kZWxldGVDb2xsZWN0aW9uKCk7XHJcbiAgICAvKipcclxuICAgICAqIFRleHQgYXJlYSBoZWlnaHQgb24gdHlwaW5nXHJcbiAgICAgKi9cclxuICAgIHZhciB0ZXh0QXJlYVRhcmdldCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgndGV4dGFyZWEuZm9ybV9faW5wdXQnKTtcclxuICAgIGlmICh0ZXh0QXJlYVRhcmdldC5sZW5ndGggPiAwKSB7XHJcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2lucHV0JywgJ3RleHRhcmVhLmZvcm1fX2lucHV0JywgZnVuY3Rpb24gKGV2ZW50KSB7XHJcbiAgICAgICAgICAgIGZvcm1CdWlsZGVyLnRleHRBcmVhSGVpZ2h0KGV2ZW50KTtcclxuICAgICAgICB9KTtcclxuICAgIH1cclxuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdzZWxlY3QyOm9wZW4nLCAnLnNlbGVjdDInLCBmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgdmFyIHNlbGVjdF9zZWFyY2ggPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcuc2VsZWN0Mi1zZWFyY2hfX2ZpZWxkJyk7XHJcbiAgICAgICAgaWYgKHNlbGVjdF9zZWFyY2gpIHtcclxuICAgICAgICAgICAgc2VsZWN0X3NlYXJjaC5mb2N1cygpO1xyXG4gICAgICAgIH1cclxuICAgIH0pO1xyXG4gICAgLyoqXHJcbiAgICAgKiBjaGVja3MgcmVnaXN0cmF0aW9uIGFnZW5jeSwgY291bnRyeSBhbmQgcmVnaXN0cmF0aW9uIG51bWJlciB0byBkZWR1Y2UgaWRlbnRpZmllclxyXG4gICAgICovXHJcbiAgICB1cGRhdGVSZWdpc3RyYXRpb25BZ2VuY3koKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjb3JnYW5pemF0aW9uX2NvdW50cnknKSk7XHJcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbmlzYXRpb25faWRlbnRpZmllcicpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJyk7XHJcbiAgICBmdW5jdGlvbiB1cGRhdGVSZWdpc3RyYXRpb25BZ2VuY3koY291bnRyeSkge1xyXG4gICAgICAgIGlmIChjb3VudHJ5LnZhbCgpKSB7XHJcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuYWpheCh7IHVybDogJy9vcmdhbmlzYXRpb24vYWdlbmN5LycgKyBjb3VudHJ5LnZhbCgpIH0pLnRoZW4oZnVuY3Rpb24gKHJlc3BvbnNlKSB7XHJcbiAgICAgICAgICAgICAgICB2YXIgX2E7XHJcbiAgICAgICAgICAgICAgICB2YXIgY3VycmVudF92YWwgPSAoX2EgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScpLnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnJztcclxuICAgICAgICAgICAgICAgIHZhciB2YWwgPSBmYWxzZTtcclxuICAgICAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI29yZ2FuaXphdGlvbl9yZWdpc3RyYXRpb25fYWdlbmN5JykuZW1wdHkoKTtcclxuICAgICAgICAgICAgICAgIGZvciAodmFyIGRhdGEgaW4gcmVzcG9uc2UuZGF0YSkge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmIChkYXRhID09PSBjdXJyZW50X3ZhbCkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YWwgPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC5hcHBlbmQobmV3IE9wdGlvbihyZXNwb25zZS5kYXRhW2RhdGFdLCBkYXRhLCB0cnVlLCB0cnVlKSlcclxuICAgICAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcclxuICAgICAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjb3JnYW5pemF0aW9uX3JlZ2lzdHJhdGlvbl9hZ2VuY3knKVxyXG4gICAgICAgICAgICAgICAgICAgIC52YWwodmFsID8gY3VycmVudF92YWwgOiAnJylcclxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJyk7XHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgIH1cclxuICAgIH1cclxuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdzZWxlY3QyOnNlbGVjdCcsICcjb3JnYW5pemF0aW9uX2NvdW50cnknLCBmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgdXBkYXRlUmVnaXN0cmF0aW9uQWdlbmN5KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKSk7XHJcbiAgICB9KTtcclxuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdzZWxlY3QyOnNlbGVjdCcsICcjb3JnYW5pemF0aW9uX3JlZ2lzdHJhdGlvbl9hZ2VuY3knLCBmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgdmFyIGlkZW50aWZpZXIgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykudmFsKCkgKyAnLScgKyAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNyZWdpc3RyYXRpb25fbnVtYmVyJykudmFsKCk7XHJcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjb3JnYW5pc2F0aW9uX2lkZW50aWZpZXInKS52YWwoaWRlbnRpZmllcik7XHJcbiAgICB9KTtcclxuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdzZWxlY3QyOmNsZWFyJywgJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScsIGZ1bmN0aW9uICgpIHtcclxuICAgICAgICB2YXIgaWRlbnRpZmllciA9ICctJyArICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI3JlZ2lzdHJhdGlvbl9udW1iZXInKS52YWwoKTtcclxuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbmlzYXRpb25faWRlbnRpZmllcicpLnZhbChpZGVudGlmaWVyKTtcclxuICAgIH0pO1xyXG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2tleXVwJywgJyNyZWdpc3RyYXRpb25fbnVtYmVyJywgZnVuY3Rpb24gKCkge1xyXG4gICAgICAgIHZhciBpZGVudGlmaWVyID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjb3JnYW5pemF0aW9uX3JlZ2lzdHJhdGlvbl9hZ2VuY3knKS52YWwoKSArICctJyArICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS52YWwoKTtcclxuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbmlzYXRpb25faWRlbnRpZmllcicpLnZhbChpZGVudGlmaWVyKTtcclxuICAgIH0pO1xyXG59KTtcclxuIl0sIm5hbWVzIjpbIl9faW1wb3J0RGVmYXVsdCIsIm1vZCIsIl9fZXNNb2R1bGUiLCJPYmplY3QiLCJkZWZpbmVQcm9wZXJ0eSIsImV4cG9ydHMiLCJ2YWx1ZSIsIkR5bmFtaWNGaWVsZCIsImpxdWVyeV8xIiwicmVxdWlyZSIsInByb3RvdHlwZSIsImhpZGVTaG93Rm9ybUZpZWxkcyIsImh1bWFuaXRhcmlhblNjb3BlSGlkZVZvY2FidWxhcnlVcmkiLCJjb3VudHJ5QnVkZ2V0SGlkZUNvZGVGaWVsZCIsImFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkIiwic2VjdG9yVm9jYWJ1bGFyeUhpZGVGaWVsZCIsInBvbGljeVZvY2FidWxhcnlIaWRlRmllbGQiLCJyZWNpcGllbnRWb2NhYnVsYXJ5SGlkZUZpZWxkIiwidGFnVm9jYWJ1bGFyeUhpZGVGaWVsZCIsInRyYW5zYWN0aW9uQWlkVHlwZVZvY2FidWxhcnlIaWRlRmllbGQiLCJpbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGRVcmkiLCJfdGhpcyIsImh1bWFuaXRhcmlhblNjb3BlVm9jYWJ1bGFyeSIsImxlbmd0aCIsImVhY2giLCJpbmRleCIsInNjb3BlIiwiX2EiLCJ2YWwiLCJoaWRlSHVtYW5pdGFyaWFuU2NvcGVGaWVsZCIsInRvU3RyaW5nIiwib24iLCJlIiwicGFyYW1zIiwiZGF0YSIsImlkIiwidGFyZ2V0IiwiY2xvc2VzdCIsImZpbmQiLCJzaG93IiwicmVtb3ZlQXR0ciIsInRyaWdnZXIiLCJoaWRlIiwiYXR0ciIsInJlZmVyZW5jZVZvY2FidWxhcnkiLCJpbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGQiLCJyZWZlcmVuY2VVcmkiLCJjb3VudHJ5QnVkZ2V0Vm9jYWJ1bGFyeSIsImhpZGVDb3VudHJ5QnVkZ2V0RmllbGQiLCJjb3VudHJ5QnVkZ2V0Q29kZUlucHV0IiwiY291bnRyeUJ1ZGdldENvZGVTZWxlY3QiLCJhaWR0eXBlX3ZvY2FidWxhcnkiLCJpdGVtIiwiaGlkZUFpZFR5cGVTZWxlY3RGaWVsZCIsImhpZGVUcmFuc2FjdGlvbkFpZFR5cGVTZWxlY3RGaWVsZCIsImRlZmF1bHRfYWlkX3R5cGUiLCJlYXJtYXJraW5nX2NhdGVnb3J5IiwiZWFybWFya2luZ19tb2RhbGl0eSIsImNhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllcyIsImNhc2UxIiwiY2FzZTIiLCJjYXNlMyIsImNhc2U0IiwiYWlkX3R5cGUiLCJwb2xpY3ltYWtlcl92b2NhYnVsYXJ5IiwicG9saWN5X21hcmtlciIsImhpZGVQb2xpY3lNYWtlckZpZWxkIiwiY2FzZTFfc2hvdyIsImNhc2UyX3Nob3ciLCJzZWN0b3Jfdm9jYWJ1bGFyeSIsInNlY3RvciIsImhpZGVTZWN0b3JGaWVsZCIsImNhc2U3X3Nob3ciLCJjYXNlOF9zaG93IiwiY2FzZTk4Xzk5X3Nob3ciLCJkZWZhdWx0X3Nob3ciLCJjYXNlNyIsImNhc2U4IiwiY2FzZTk4Xzk5IiwiZGVmYXVsdF9oaWRlIiwicmVnaW9uX3ZvY2FidWxhcnkiLCJyZWdpb25fdm9jYWIiLCJoaWRlUmVjaXBpZW50UmVnaW9uRmllbGQiLCJjYXNlOTlfc2hvdyIsImNhc2U5OSIsImNvbnNvbGUiLCJsb2ciLCJ1cGRhdGVBY3Rpdml0eUlkZW50aWZpZXIiLCJhY3Rpdml0eV9pZGVudGlmaWVyIiwiY29uY2F0IiwidGFnX3ZvY2FidWxhcnkiLCJ0YWciLCJoaWRlVGFnRmllbGQiLCJjYXNlM19zaG93IiwiRHluYW1pY0ZpZWxkXzEiLCJkeW5hbWljRmllbGQiLCJGb3JtQnVpbGRlciIsImFkZEZvcm0iLCJldiIsInByZXZlbnREZWZhdWx0IiwiY29udGFpbmVyIiwiY291bnQiLCJwYXJzZUludCIsInBhcmVudCIsInBhcmVudF9jb3VudCIsInByZXZBbGwiLCJ3cmFwcGVyX3BhcmVudF9jb3VudCIsInByb3RvIiwicmVwbGFjZSIsInByZXYiLCJhcHBlbmQiLCJjaGlsZHJlbiIsImxhc3QiLCJzZWxlY3QyIiwicGxhY2Vob2xkZXIiLCJhbGxvd0NsZWFyIiwid3JhcEFsbCIsImFkZFBhcmVudEZvcm0iLCJhZGRXcmFwcGVyT25BZGQiLCJkZWxldGVGb3JtIiwiY29sbGVjdGlvbkxlbmd0aCIsInRnIiwibmV4dCIsInJlbW92ZSIsImRlbGV0ZVBhcmVudEZvcm0iLCJhZGRXcmFwcGVyIiwiZm9ybUZpZWxkIiwidGV4dEFyZWFIZWlnaHQiLCJoZWlnaHQiLCJzY3JvbGxIZWlnaHQiLCJjc3MiLCJhZGRUb0NvbGxlY3Rpb24iLCJldmVudCIsImRlbGV0ZUNvbGxlY3Rpb24iLCJkZWxldGVDb25maXJtYXRpb24iLCJjYW5jZWxQb3B1cCIsImRlbGV0ZUNvbmZpcm0iLCJkZWxldGVJbmRleCIsImNoaWxkT3JQYXJlbnQiLCJmYWRlSW4iLCJmYWRlT3V0IiwiX2IiLCJfYyIsImVuZHBvaW50IiwiZmlsZV9uYW1lIiwic3BsaXQiLCJwb3AiLCJmb3JtQnVpbGRlciIsInRleHRBcmVhVGFyZ2V0Iiwic2VsZWN0X3NlYXJjaCIsImRvY3VtZW50IiwicXVlcnlTZWxlY3RvciIsImZvY3VzIiwidXBkYXRlUmVnaXN0cmF0aW9uQWdlbmN5IiwiY291bnRyeSIsImFqYXgiLCJ1cmwiLCJ0aGVuIiwicmVzcG9uc2UiLCJjdXJyZW50X3ZhbCIsImVtcHR5IiwiT3B0aW9uIiwiaWRlbnRpZmllciJdLCJzb3VyY2VSb290IjoiIn0=
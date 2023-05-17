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

        _this.hidePolicyMakerField((0, jquery_1["default"])(target), '99');
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
      default:
        index.closest('.form-field-group').find(case2_show).show().removeAttr('disabled').closest('.form-field').show();
        index.closest('.form-field-group').find(case2).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
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

        _this.hideSectorField((0, jquery_1["default"])(target), '');
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

        _this.hideRecipientRegionField((0, jquery_1["default"])(target), '');
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

        _this.hideTagField((0, jquery_1["default"])(target), '');
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

var axios_1 = __importDefault(__webpack_require__(/*! axios */ "./node_modules/axios/index.js"));

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
    var parent_count = (0, jquery_1["default"])(target).attr('parent_count') ? parseInt((0, jquery_1["default"])(target).attr('parent_count')) : (0, jquery_1["default"])(target).parents('.multi-form').index() - 1;
    var wrapper_parent_count = (0, jquery_1["default"])(target).attr('wrapped_parent_count') ? parseInt((0, jquery_1["default"])(target).attr('wrapped_parent_count')) : (0, jquery_1["default"])(target).parents('.wrapped-child-body').index() - 1;
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
      if ((0, jquery_1["default"])(event.target).hasClass('add-icon')) {
        event.stopPropagation();
        (0, jquery_1["default"])(event.target).parent('button').trigger('click');
      } else {
        _this.addForm(event);
      }
    });
    (0, jquery_1["default"])('.add_to_parent').on('click', function (event) {
      if ((0, jquery_1["default"])(event.target).hasClass('add-icon')) {
        event.stopPropagation();
        (0, jquery_1["default"])(event.target).parent('button').trigger('click');
      } else {
        _this.addParentForm(event);
      }
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
    }); // update format on change of document link

    (0, jquery_1["default"])('body').on('keyup', 'input[id*="[url]"]', function () {
      var _this = this;

      var _a;

      var filePath = ((_a = (0, jquery_1["default"])(this).val()) !== null && _a !== void 0 ? _a : '').toString();
      var url = "/mimetype?url=".concat(filePath, "&type=url");
      (0, jquery_1["default"])(this).closest('.form-field').find('.text-danger').remove();

      if (filePath !== '') {
        axios_1["default"].get(url).then(function (response) {
          if (response.data.success) {
            var format = response.data.data.mimetype;
            (0, jquery_1["default"])(_this).closest('.form-field-group').find('select[id*="[format]"]').val(format).trigger('change');
          } else {
            var message = "<div class='text-danger error'>" + response.data.message + "</div>";
            (0, jquery_1["default"])(_this).closest('.form-field').append("<div class='text-danger error'>" + response.data.message + "</div>");
            console.log(message);
            (0, jquery_1["default"])(_this).closest('.form-field-group').find('select[id*="[format]"]').val('').trigger('change');
          }
        });
        (0, jquery_1["default"])(this).closest('.form-field-group').find('input[id*="[document]"]').val('').trigger('change');
      }
    });
    (0, jquery_1["default"])('body').on('change', 'input[id*="[document]"]', function () {
      var _this = this;

      var _a;

      console.log('changed');
      var filePath = ((_a = (0, jquery_1["default"])(this).val()) !== null && _a !== void 0 ? _a : '').toString();
      var url = "/mimetype?url=".concat(filePath, "&&type=document");

      if (filePath !== '') {
        axios_1["default"].get(url).then(function (response) {
          if (response.data.success) {
            var format = response.data.data.mimetype;
            (0, jquery_1["default"])(_this).closest('.form-field-group').find('select[id*="[format]"]').val(format).trigger('change');
          } else {
            (0, jquery_1["default"])(_this).closest('.form-field-group').find('select[id*="[format]"]').val('').trigger('change');
          }
        });
        (0, jquery_1["default"])(this).closest('.form-field-group').find('input[id*="[url]"]').val('').trigger('change');
      } else {}

      (0, jquery_1["default"])(this).closest('.form-field-group').find('select[id*="[format]"]').val('').trigger('change');
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
  }); // add class to title of collection when validation error occurs on collection level

  var subelement = document.querySelectorAll('.subelement');

  for (var i = 0; i < subelement.length; i++) {
    var title = subelement[i].querySelector('.control-label');
    var errorContainer = subelement[i].querySelector('.collection_error');
    var childCount = errorContainer === null || errorContainer === void 0 ? void 0 : errorContainer.childElementCount;

    if (childCount && childCount > 0) {
      title === null || title === void 0 ? void 0 : title.classList.add('error-title');
    }
  } // Adding cursor not allowed to <select> where elementJsonSchema read_only : true


  var readOnlySelects = document.querySelectorAll("select.cursor-not-allowed");

  for (var i = 0; i < readOnlySelects.length; i++) {
    var select = readOnlySelects[i];
    var selectElementParentWrapper = select.nextSibling;
    var selectElementParent = selectElementParentWrapper === null || selectElementParentWrapper === void 0 ? void 0 : selectElementParentWrapper.firstChild;
    var selectElement = selectElementParent === null || selectElementParent === void 0 ? void 0 : selectElementParent.firstChild;

    if (selectElement) {
      selectElement.style.cursor = "not-allowed";
    }
  }
});

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["/js/vendor"], () => (__webpack_exec__("./resources/assets/js/scripts/formbuilder.ts")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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LEtBQUssS0FBSyxDQUEzRSxHQUErRSxLQUFLLENBQXBGLEdBQXdGQSwwQkFBMEIsQ0FBQ0csVUFBN0k7SUFDQSxJQUFJQyxhQUFhLEdBQUdGLG1CQUFtQixLQUFLLElBQXhCLElBQWdDQSxtQkFBbUIsS0FBSyxLQUFLLENBQTdELEdBQWlFLEtBQUssQ0FBdEUsR0FBMEVBLG1CQUFtQixDQUFDQyxVQUFsSDs7SUFDQSxJQUFJQyxhQUFKLEVBQW1CO01BQ2ZBLGFBQWEsQ0FBQ0MsS0FBZCxDQUFvQkMsTUFBcEIsR0FBNkIsYUFBN0I7SUFDSDtFQUNKO0FBQ0osQ0FyRkQiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2pzL3NjcmlwdHMvRHluYW1pY0ZpZWxkLnRzIiwid2VicGFjazovLy8uL3Jlc291cmNlcy9hc3NldHMvanMvc2NyaXB0cy9mb3JtYnVpbGRlci50cyJdLCJzb3VyY2VzQ29udGVudCI6WyJcInVzZSBzdHJpY3RcIjtcbnZhciBfX2ltcG9ydERlZmF1bHQgPSAodGhpcyAmJiB0aGlzLl9faW1wb3J0RGVmYXVsdCkgfHwgZnVuY3Rpb24gKG1vZCkge1xuICAgIHJldHVybiAobW9kICYmIG1vZC5fX2VzTW9kdWxlKSA/IG1vZCA6IHsgXCJkZWZhdWx0XCI6IG1vZCB9O1xufTtcbk9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBcIl9fZXNNb2R1bGVcIiwgeyB2YWx1ZTogdHJ1ZSB9KTtcbmV4cG9ydHMuRHluYW1pY0ZpZWxkID0gdm9pZCAwO1xudmFyIGpxdWVyeV8xID0gX19pbXBvcnREZWZhdWx0KHJlcXVpcmUoXCJqcXVlcnlcIikpO1xucmVxdWlyZShcInNlbGVjdDJcIik7XG52YXIgRHluYW1pY0ZpZWxkID0gLyoqIEBjbGFzcyAqLyAoZnVuY3Rpb24gKCkge1xuICAgIGZ1bmN0aW9uIER5bmFtaWNGaWVsZCgpIHtcbiAgICB9XG4gICAgLyoqXG4gICAgICogSGlkZSBhbmQgU2hvdyBkaWZmZXJlbnQgZm9ybSBmaWVsZHMgYmFzZWQgb24gdm9jYWJ1bGFyeSBhbmQgb3RoZXIgdHlwZXNcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmhpZGVTaG93Rm9ybUZpZWxkcyA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdGhpcy5odW1hbml0YXJpYW5TY29wZUhpZGVWb2NhYnVsYXJ5VXJpKCk7XG4gICAgICAgIHRoaXMuY291bnRyeUJ1ZGdldEhpZGVDb2RlRmllbGQoKTtcbiAgICAgICAgdGhpcy5haWRUeXBlVm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICB0aGlzLnNlY3RvclZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgdGhpcy5wb2xpY3lWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIHRoaXMucmVjaXBpZW50Vm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICB0aGlzLnNlY3RvclZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgdGhpcy50YWdWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIHRoaXMudHJhbnNhY3Rpb25BaWRUeXBlVm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICB0aGlzLmluZGljYXRvclJlZmVyZW5jZUhpZGVGaWVsZFVyaSgpO1xuICAgIH07XG4gICAgLyoqXG4gICAgICogSHVtYW5pdGFyaWFuIFNjb3BlIEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaHVtYW5pdGFyaWFuU2NvcGVIaWRlVm9jYWJ1bGFyeVVyaSA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgdmFyIGh1bWFuaXRhcmlhblNjb3BlVm9jYWJ1bGFyeSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnc2VsZWN0W2lkXj1cImh1bWFuaXRhcmlhbl9zY29wZVwiXVtpZCo9XCJbdm9jYWJ1bGFyeV1cIl0nKTtcbiAgICAgICAgaWYgKGh1bWFuaXRhcmlhblNjb3BlVm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICAvLyBoaWRlIGZpZWxkcyBvbiBwYWdlIGxvYWRcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuZWFjaChodW1hbml0YXJpYW5TY29wZVZvY2FidWxhcnksIGZ1bmN0aW9uIChpbmRleCwgc2NvcGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICAgICAgdmFyIHZhbCA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShzY29wZSkudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcnO1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVIdW1hbml0YXJpYW5TY29wZUZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShzY29wZSksIHZhbC50b1N0cmluZygpKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgLy8gaGlkZS9zaG93IGZpZWxkcyBvbiB2YWx1ZSBjaGFuZ2VcbiAgICAgICAgICAgIGh1bWFuaXRhcmlhblNjb3BlVm9jYWJ1bGFyeS5vbignc2VsZWN0MjpzZWxlY3QnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciB2YWwgPSBlLnBhcmFtcy5kYXRhLmlkO1xuICAgICAgICAgICAgICAgIHZhciBpbmRleCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVIdW1hbml0YXJpYW5TY29wZUZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShpbmRleCksIHZhbCk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIC8vIGhpZGUvc2hvdyBmaWVsZHMgb24gdmFsdWUgY2xlYXJcbiAgICAgICAgICAgIGh1bWFuaXRhcmlhblNjb3BlVm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIGluZGV4ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZUh1bWFuaXRhcmlhblNjb3BlRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGluZGV4KSwgJycpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8vIGhpZGUgY291bnRyeSBidWRnZXQgYmFzZWQgb24gdm9jYWJ1bGFyeVxuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaGlkZUh1bWFuaXRhcmlhblNjb3BlRmllbGQgPSBmdW5jdGlvbiAoaW5kZXgsIHZhbHVlKSB7XG4gICAgICAgIHZhciBodW1hbml0YXJpYW5TY29wZUhpZGVWb2NhYnVsYXJ5VXJpID0gJ2lucHV0W2lkXj1cImh1bWFuaXRhcmlhbl9zY29wZVwiXVtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdJztcbiAgICAgICAgaWYgKHZhbHVlID09PSAnOTknKSB7XG4gICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgLmZpbmQoaHVtYW5pdGFyaWFuU2NvcGVIaWRlVm9jYWJ1bGFyeVVyaSlcbiAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgIH1cbiAgICAgICAgZWxzZSB7XG4gICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgLmZpbmQoaHVtYW5pdGFyaWFuU2NvcGVIaWRlVm9jYWJ1bGFyeVVyaSlcbiAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAqIEh1bWFuaXRhcmlhbiBTY29wZSBGb3JtIFBhZ2VcbiAgICpcbiAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmluZGljYXRvclJlZmVyZW5jZUhpZGVGaWVsZFVyaSA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgdmFyIHJlZmVyZW5jZVZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdFtpZF49XCJyZWZlcmVuY2VcIl1baWQqPVwiW3ZvY2FidWxhcnldXCJdJyk7XG4gICAgICAgIGlmIChyZWZlcmVuY2VWb2NhYnVsYXJ5Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIC8vIGhpZGUgZmllbGRzIG9uIHBhZ2UgbG9hZFxuICAgICAgICAgICAganF1ZXJ5XzEuZGVmYXVsdC5lYWNoKHJlZmVyZW5jZVZvY2FidWxhcnksIGZ1bmN0aW9uIChpbmRleCwgc2NvcGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICAgICAgdmFyIHZhbCA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShzY29wZSkudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcnO1xuICAgICAgICAgICAgICAgIF90aGlzLmluZGljYXRvclJlZmVyZW5jZUhpZGVGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoc2NvcGUpLCB2YWwudG9TdHJpbmcoKSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIC8vIGhpZGUvc2hvdyBmaWVsZHMgb24gdmFsdWUgY2hhbmdlXG4gICAgICAgICAgICByZWZlcmVuY2VWb2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOnNlbGVjdCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIHZhbCA9IGUucGFyYW1zLmRhdGEuaWQ7XG4gICAgICAgICAgICAgICAgdmFyIGluZGV4ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShpbmRleCksIHZhbCk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIC8vIGhpZGUvc2hvdyBmaWVsZHMgb24gdmFsdWUgY2xlYXJcbiAgICAgICAgICAgIHJlZmVyZW5jZVZvY2FidWxhcnkub24oJ3NlbGVjdDI6Y2xlYXInLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciBpbmRleCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmluZGljYXRvclJlZmVyZW5jZUhpZGVGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaW5kZXgpLCAnJyk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLy8gaGlkZSBjb3VudHJ5IGJ1ZGdldCBiYXNlZCBvbiB2b2NhYnVsYXJ5XG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5pbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGQgPSBmdW5jdGlvbiAoaW5kZXgsIHZhbHVlKSB7XG4gICAgICAgIHZhciByZWZlcmVuY2VVcmkgPSAnaW5wdXRbaWRePVwicmVmZXJlbmNlXCJdW2lkKj1cIltpbmRpY2F0b3JfdXJpXVwiXSc7XG4gICAgICAgIGlmICh2YWx1ZSA9PT0gJzk5Jykge1xuICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgIC5maW5kKHJlZmVyZW5jZVVyaSlcbiAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgIH1cbiAgICAgICAgZWxzZSB7XG4gICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgLmZpbmQocmVmZXJlbmNlVXJpKVxuICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBDb3VudHJ5IEJ1ZGdldCBGb3JtIFBhZ2VcbiAgICAgKlxuICAgICAqIEBMb2dpYyBzaG93L2hpZGUgJ2NvZGUnIGZpZWxkIGJhc2VkIG9uICdAdm9jYWJ1bGFyeScgZmllbGQgdmFsdWVcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmNvdW50cnlCdWRnZXRIaWRlQ29kZUZpZWxkID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuICAgICAgICB2YXIgX2E7XG4gICAgICAgIHZhciBjb3VudHJ5QnVkZ2V0Vm9jYWJ1bGFyeSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnc2VsZWN0I2NvdW50cnlfYnVkZ2V0X3ZvY2FidWxhcnknKTtcbiAgICAgICAgaWYgKGNvdW50cnlCdWRnZXRWb2NhYnVsYXJ5Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIC8vIGhpZGUvc2hvdyBvbiBwYWdlIGxvYWRcbiAgICAgICAgICAgIHZhciB2YWwgPSAoX2EgPSBjb3VudHJ5QnVkZ2V0Vm9jYWJ1bGFyeS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJzEnO1xuICAgICAgICAgICAgdGhpcy5oaWRlQ291bnRyeUJ1ZGdldEZpZWxkKHZhbC50b1N0cmluZygpKTtcbiAgICAgICAgICAgIC8vIGhpZGUvc2hvdyBvbiB2YWx1ZSBjaGFuZ2VcbiAgICAgICAgICAgIGNvdW50cnlCdWRnZXRWb2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOnNlbGVjdCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIHZhbCA9IGUucGFyYW1zLmRhdGEuaWQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZUNvdW50cnlCdWRnZXRGaWVsZCh2YWwpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAvL2hpZGUvc2hvdyBiYXNlZCBvbiB2YWx1ZSBjbGVhcmVkXG4gICAgICAgICAgICBjb3VudHJ5QnVkZ2V0Vm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlQ291bnRyeUJ1ZGdldEZpZWxkKCcnKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBIaWRlIENvdW50cnkgQnVkZ2V0IEZpZWxkc1xuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaGlkZUNvdW50cnlCdWRnZXRGaWVsZCA9IGZ1bmN0aW9uICh2YWx1ZSkge1xuICAgICAgICB2YXIgY291bnRyeUJ1ZGdldENvZGVJbnB1dCA9ICdpbnB1dFtpZF49XCJidWRnZXRfaXRlbVwiXVtpZCo9XCJbY29kZV90ZXh0XVwiXScsIGNvdW50cnlCdWRnZXRDb2RlU2VsZWN0ID0gJ3NlbGVjdFtpZF49XCJidWRnZXRfaXRlbVwiXVtpZCo9XCJbY29kZV1cIl0nO1xuICAgICAgICBpZiAodmFsdWUgPT09ICcxJykge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGNvdW50cnlCdWRnZXRDb2RlU2VsZWN0KVxuICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoY291bnRyeUJ1ZGdldENvZGVJbnB1dCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKS5jbG9zZXN0KCcuZm9ybS1maWVsZCcpLnNob3coKTtcbiAgICAgICAgfVxuICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShjb3VudHJ5QnVkZ2V0Q29kZVNlbGVjdCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKS5jbG9zZXN0KCcuZm9ybS1maWVsZCcpLnNob3coKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShjb3VudHJ5QnVkZ2V0Q29kZUlucHV0KVxuICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBBaWRUeXBlIEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgYW5kIGNvZGVzIGZpZWxkIGJhc2VkIG9uICdAdm9jYWJ1bGFyeScgZmllbGQgdmFsdWVcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuICAgICAgICB2YXIgYWlkdHlwZV92b2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3RbaWQqPVwiZGVmYXVsdF9haWRfdHlwZV92b2NhYnVsYXJ5XCJdJyk7XG4gICAgICAgIGlmIChhaWR0eXBlX3ZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAganF1ZXJ5XzEuZGVmYXVsdC5lYWNoKGFpZHR5cGVfdm9jYWJ1bGFyeSwgZnVuY3Rpb24gKGluZGV4LCBpdGVtKSB7XG4gICAgICAgICAgICAgICAgdmFyIF9hO1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGl0ZW0pLnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnMSc7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZUFpZFR5cGVTZWxlY3RGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaXRlbSksIGRhdGEudG9TdHJpbmcoKSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIGFpZHR5cGVfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpzZWxlY3QnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gZS5wYXJhbXMuZGF0YS5pZDtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZUFpZFR5cGVTZWxlY3RGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgZGF0YSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIGFpZHR5cGVfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVBaWRUeXBlU2VsZWN0RmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksICcnKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBBaWRUeXBlIEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgYW5kIGNvZGVzIGZpZWxkIGJhc2VkIG9uICdAdm9jYWJ1bGFyeScgZmllbGQgdmFsdWVcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLnRyYW5zYWN0aW9uQWlkVHlwZVZvY2FidWxhcnlIaWRlRmllbGQgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgIHZhciBhaWR0eXBlX3ZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdFtpZCo9XCJhaWRfdHlwZV92b2NhYnVsYXJ5XCJdJyk7XG4gICAgICAgIGlmIChhaWR0eXBlX3ZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAganF1ZXJ5XzEuZGVmYXVsdC5lYWNoKGFpZHR5cGVfdm9jYWJ1bGFyeSwgZnVuY3Rpb24gKGluZGV4LCBpdGVtKSB7XG4gICAgICAgICAgICAgICAgdmFyIF9hO1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGl0ZW0pLnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnMSc7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVRyYW5zYWN0aW9uQWlkVHlwZVNlbGVjdEZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShpdGVtKSwgZGF0YS50b1N0cmluZygpKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgYWlkdHlwZV92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOnNlbGVjdCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSBlLnBhcmFtcy5kYXRhLmlkO1xuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlVHJhbnNhY3Rpb25BaWRUeXBlU2VsZWN0RmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksIGRhdGEpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICBhaWR0eXBlX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6Y2xlYXInLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlVHJhbnNhY3Rpb25BaWRUeXBlU2VsZWN0RmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksICcnKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBIaWRlIEFpZCBUeXBlIFNlbGVjdCBGaWVsZHNcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmhpZGVBaWRUeXBlU2VsZWN0RmllbGQgPSBmdW5jdGlvbiAoaW5kZXgsIHZhbHVlKSB7XG4gICAgICAgIHZhciBkZWZhdWx0X2FpZF90eXBlID0gJ3NlbGVjdFtpZCo9XCJbZGVmYXVsdF9haWRfdHlwZV1cIl0nLCBlYXJtYXJraW5nX2NhdGVnb3J5ID0gJ3NlbGVjdFtpZCo9XCJbZWFybWFya2luZ19jYXRlZ29yeV1cIl0nLCBlYXJtYXJraW5nX21vZGFsaXR5ID0gJ3NlbGVjdFtpZCo9XCJbZWFybWFya2luZ19tb2RhbGl0eV1cIl0nLCBjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXMgPSAnc2VsZWN0W2lkKj1cIltjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXNdXCJdJywgY2FzZTEgPSAnc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX2NhdGVnb3J5XVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfbW9kYWxpdHldXCJdLHNlbGVjdFtpZCo9XCJbY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzXVwiXScsIGNhc2UyID0gJ3NlbGVjdFtpZCo9XCJbZGVmYXVsdF9haWRfdHlwZV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX21vZGFsaXR5XVwiXSxzZWxlY3RbaWQqPVwiW2Nhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllc11cIl0nLCBjYXNlMyA9ICdzZWxlY3RbaWQqPVwiW2RlZmF1bHRfYWlkX3R5cGVdXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19jYXRlZ29yeV1cIl0sc2VsZWN0W2lkKj1cIltjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXNdXCJdJywgY2FzZTQgPSAnc2VsZWN0W2lkKj1cIltkZWZhdWx0X2FpZF90eXBlXVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfY2F0ZWdvcnldXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19tb2RhbGl0eV1cIl0nO1xuICAgICAgICBzd2l0Y2ggKHZhbHVlKSB7XG4gICAgICAgICAgICBjYXNlICcyJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChlYXJtYXJraW5nX2NhdGVnb3J5KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMilcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnMyc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoZWFybWFya2luZ19tb2RhbGl0eSlcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTMpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzQnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllcylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTQpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGRlZmF1bHQ6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoZGVmYXVsdF9haWRfdHlwZSlcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTEpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogSGlkZSBUcmFuc2FjdGlvbiBBaWQgVHlwZSBTZWxlY3QgRmllbGRzXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5oaWRlVHJhbnNhY3Rpb25BaWRUeXBlU2VsZWN0RmllbGQgPSBmdW5jdGlvbiAoaW5kZXgsIHZhbHVlKSB7XG4gICAgICAgIHZhciBhaWRfdHlwZSA9ICdzZWxlY3RbaWQqPVwiW2FpZF90eXBlX2NvZGVdXCJdJywgZWFybWFya2luZ19jYXRlZ29yeSA9ICdzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfY2F0ZWdvcnldXCJdJywgZWFybWFya2luZ19tb2RhbGl0eSA9ICdzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfbW9kYWxpdHldXCJdJywgY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzID0gJ3NlbGVjdFtpZCo9XCJbY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzXVwiXScsIGNhc2UxID0gJ3NlbGVjdFtpZCo9XCJbZWFybWFya2luZ19jYXRlZ29yeV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX21vZGFsaXR5XVwiXSxzZWxlY3RbaWQqPVwiW2Nhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllc11cIl0nLCBjYXNlMiA9ICdzZWxlY3RbaWQqPVwiW2FpZF90eXBlX2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19tb2RhbGl0eV1cIl0sc2VsZWN0W2lkKj1cIltjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXNdXCJdJywgY2FzZTMgPSAnc2VsZWN0W2lkKj1cIlthaWRfdHlwZV9jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfY2F0ZWdvcnldXCJdLHNlbGVjdFtpZCo9XCJbY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzXVwiXScsIGNhc2U0ID0gJ3NlbGVjdFtpZCo9XCJbYWlkX3R5cGVfY29kZV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX2NhdGVnb3J5XVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfbW9kYWxpdHldXCJdJztcbiAgICAgICAgc3dpdGNoICh2YWx1ZSkge1xuICAgICAgICAgICAgY2FzZSAnMic6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoZWFybWFya2luZ19jYXRlZ29yeSlcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTIpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzMnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGVhcm1hcmtpbmdfbW9kYWxpdHkpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UzKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICc0JzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXMpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U0KVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBkZWZhdWx0OlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGFpZF90eXBlKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBQb2xpY3kgTWFya2VyIEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgYW5kIGNvZGVzIGZpZWxkIGJhc2VkIG9uICdAdm9jYWJ1bGFyeScgZmllbGQgdmFsdWVcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLnBvbGljeVZvY2FidWxhcnlIaWRlRmllbGQgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgIHZhciBwb2xpY3ltYWtlcl92b2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3RbaWQqPVwicG9saWN5X21hcmtlcl92b2NhYnVsYXJ5XCJdJyk7XG4gICAgICAgIGlmIChwb2xpY3ltYWtlcl92b2NhYnVsYXJ5Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuZWFjaChwb2xpY3ltYWtlcl92b2NhYnVsYXJ5LCBmdW5jdGlvbiAoaW5kZXgsIHBvbGljeV9tYXJrZXIpIHtcbiAgICAgICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSAoX2EgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkocG9saWN5X21hcmtlcikudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcxJztcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlUG9saWN5TWFrZXJGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkocG9saWN5X21hcmtlciksIGRhdGEudG9TdHJpbmcoKSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIHBvbGljeW1ha2VyX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IGUucGFyYW1zLmRhdGEuaWQ7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVQb2xpY3lNYWtlckZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCBkYXRhKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgcG9saWN5bWFrZXJfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVQb2xpY3lNYWtlckZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCAnOTknKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBIaWRlcyBQb2xpY3kgTWFya2VyIEZvcm0gRmllbGRzXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5oaWRlUG9saWN5TWFrZXJGaWVsZCA9IGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcbiAgICAgICAgdmFyIGNhc2UxX3Nob3cgPSAnc2VsZWN0W2lkKj1cIltwb2xpY3lfbWFya2VyXVwiXScsIGNhc2UyX3Nob3cgPSAnaW5wdXRbaWQqPVwiW3BvbGljeV9tYXJrZXJfdGV4dF1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXScsIGNhc2UxID0gJ2lucHV0W2lkKj1cIltwb2xpY3lfbWFya2VyX3RleHRdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0nLCBjYXNlMiA9ICdzZWxlY3RbaWQqPVwiW3BvbGljeV9tYXJrZXJdXCJdJztcbiAgICAgICAgc3dpdGNoICh2YWx1ZSkge1xuICAgICAgICAgICAgY2FzZSAnMSc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTFfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTEpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzk5JzpcbiAgICAgICAgICAgIGRlZmF1bHQ6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTJfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTIpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogU2VjdG9yIEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgYW5kIGNvZGVzIGZpZWxkIGJhc2VkIG9uICdAdm9jYWJ1bGFyeScgZmllbGQgdmFsdWVcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLnNlY3RvclZvY2FidWxhcnlIaWRlRmllbGQgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgIHZhciBzZWN0b3Jfdm9jYWJ1bGFyeSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnc2VsZWN0W2lkKj1cInNlY3Rvcl92b2NhYnVsYXJ5XCJdJyk7XG4gICAgICAgIGlmIChzZWN0b3Jfdm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2goc2VjdG9yX3ZvY2FidWxhcnksIGZ1bmN0aW9uIChpbmRleCwgc2VjdG9yKSB7XG4gICAgICAgICAgICAgICAgdmFyIF9hO1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHNlY3RvcikudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcxJztcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlU2VjdG9yRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHNlY3RvciksIGRhdGEudG9TdHJpbmcoKSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIHNlY3Rvcl92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOnNlbGVjdCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSBlLnBhcmFtcy5kYXRhLmlkO1xuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlU2VjdG9yRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksIGRhdGEpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICBzZWN0b3Jfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVTZWN0b3JGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgJycpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEhpZGUgU2VjdG9yIEZvcm0gZmllbGRzXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5oaWRlU2VjdG9yRmllbGQgPSBmdW5jdGlvbiAoaW5kZXgsIHZhbHVlKSB7XG4gICAgICAgIHZhciBjYXNlMV9zaG93ID0gJ3NlbGVjdFtpZCo9XCJbY29kZV1cIl0nLCBjYXNlMl9zaG93ID0gJ3NlbGVjdFtpZCo9XCJbY2F0ZWdvcnlfY29kZV1cIl0nLCBjYXNlN19zaG93ID0gJ3NlbGVjdFtpZCo9XCJbc2RnX2dvYWxdXCJdJywgY2FzZThfc2hvdyA9ICdzZWxlY3RbaWQqPVwiW3NkZ190YXJnZXRdXCJdJywgY2FzZTk4Xzk5X3Nob3cgPSAnaW5wdXRbaWQqPVwiW3RleHRdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0nLCBkZWZhdWx0X3Nob3cgPSAnaW5wdXRbaWQqPVwiW3RleHRdXCJdJywgY2FzZTEgPSAnc2VsZWN0W2lkKj1cIltjYXRlZ29yeV9jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ19nb2FsXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ190YXJnZXRdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0saW5wdXRbaWQqPVwiW3RleHRdXCJdJywgY2FzZTIgPSAnaW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ19nb2FsXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ190YXJnZXRdXCJdLHNlbGVjdFtpZCo9XCJbY29kZV1cIl0saW5wdXRbaWQqPVwiW3RleHRdXCJdJywgY2FzZTcgPSAnaW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSxzZWxlY3RbaWQqPVwiW2NhdGVnb3J5X2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX3RhcmdldF1cIl0sc2VsZWN0W2lkKj1cIltjb2RlXVwiXSxpbnB1dFtpZCo9XCJbdGV4dF1cIl0nLCBjYXNlOCA9ICdpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdLHNlbGVjdFtpZCo9XCJbY2F0ZWdvcnlfY29kZV1cIl0sc2VsZWN0W2lkKj1cIltzZGdfZ29hbF1cIl0sc2VsZWN0W2lkKj1cIltjb2RlXVwiXSxpbnB1dFtpZCo9XCJbdGV4dF1cIl0nLCBjYXNlOThfOTkgPSAnc2VsZWN0W2lkKj1cIltjYXRlZ29yeV9jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ19nb2FsXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ190YXJnZXRdXCJdLHNlbGVjdFtpZCo9XCJbY29kZV1cIl0nLCBkZWZhdWx0X2hpZGUgPSAnc2VsZWN0W2lkKj1cIltjYXRlZ29yeV9jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ19nb2FsXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ190YXJnZXRdXCJdLHNlbGVjdFtpZCo9XCJbY29kZV1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSc7XG4gICAgICAgIHN3aXRjaCAodmFsdWUpIHtcbiAgICAgICAgICAgIGNhc2UgJzEnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICcyJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMl9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMilcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnNyc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTdfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTcpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzgnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U4X3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U4KVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICc5OCc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTk4Xzk5X3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U5OF85OSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnOTknOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U5OF85OV9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOThfOTkpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGRlZmF1bHQ6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoZGVmYXVsdF9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChkZWZhdWx0X2hpZGUpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogIFJlY2lwaWVudCBWb2NhYnVsYXJ5IEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgYW5kIGNvZGVzIGZpZWxkIGJhc2VkIG9uICdAdm9jYWJ1bGFyeScgZmllbGQgdmFsdWVcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLnJlY2lwaWVudFZvY2FidWxhcnlIaWRlRmllbGQgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgIHZhciByZWdpb25fdm9jYWJ1bGFyeSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnc2VsZWN0W2lkKj1cInJlZ2lvbl92b2NhYnVsYXJ5XCJdJyk7XG4gICAgICAgIGlmIChyZWdpb25fdm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2gocmVnaW9uX3ZvY2FidWxhcnksIGZ1bmN0aW9uIChpbmRleCwgcmVnaW9uX3ZvY2FiKSB7XG4gICAgICAgICAgICAgICAgdmFyIF9hO1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHJlZ2lvbl92b2NhYikudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcxJztcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlUmVjaXBpZW50UmVnaW9uRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHJlZ2lvbl92b2NhYiksIGRhdGEudG9TdHJpbmcoKSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIHJlZ2lvbl92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOnNlbGVjdCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSBlLnBhcmFtcy5kYXRhLmlkO1xuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlUmVjaXBpZW50UmVnaW9uRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksIGRhdGEpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICByZWdpb25fdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVSZWNpcGllbnRSZWdpb25GaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgJycpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEhpZGVzIFJlY2lwaWVudCBSZWdpb24gRm9ybSBGaWVsZHNcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmhpZGVSZWNpcGllbnRSZWdpb25GaWVsZCA9IGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcbiAgICAgICAgdmFyIGNhc2UxX3Nob3cgPSAnc2VsZWN0W2lkKj1cIltyZWdpb25fY29kZV1cIl0nLCBjYXNlMl9zaG93ID0gJ2lucHV0W2lkKj1cIltjdXN0b21fY29kZV1cIl0sIGlucHV0W2lkKj1cIltjb2RlXVwiXScsIGNhc2U5OV9zaG93ID0gJ2lucHV0W2lkKj1cIltjdXN0b21fY29kZV1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSwgaW5wdXRbaWQqPVwiW2NvZGVdXCJdJywgY2FzZTEgPSAnaW5wdXRbaWQqPVwiW2N1c3RvbV9jb2RlXVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdLGlucHV0W2lkKj1cIltjb2RlXVwiXScsIGNhc2UyID0gJ3NlbGVjdFtpZCo9XCJbcmVnaW9uX2NvZGVdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0nLCBjYXNlOTkgPSAnc2VsZWN0W2lkKj1cIltyZWdpb25fY29kZV1cIl0nO1xuICAgICAgICBzd2l0Y2ggKHZhbHVlKSB7XG4gICAgICAgICAgICBjYXNlICcxJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMV9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnMic6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTJfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTIpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzk5JzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOTlfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTk5KVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBkZWZhdWx0OlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIFVwZGF0ZXMgQWN0aXZpdHkgaWRlbnRpZmllclxuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUudXBkYXRlQWN0aXZpdHlJZGVudGlmaWVyID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgYWN0aXZpdHlfaWRlbnRpZmllciA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI2FjdGl2aXR5X2lkZW50aWZpZXInKTtcbiAgICAgICAgaWYgKGFjdGl2aXR5X2lkZW50aWZpZXIubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAgYWN0aXZpdHlfaWRlbnRpZmllci5vbigna2V5dXAnLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjaWF0aV9pZGVudGlmaWVyX3RleHQnKS52YWwoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuaWRlbnRpZmllcicpLmF0dHIoJ2FjdGl2aXR5X2lkZW50aWZpZXInKSArIFwiLVwiLmNvbmNhdCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykudmFsKCkpKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBUYWcgRm9ybSBQYWdlXG4gICAgICpcbiAgICAgKiBATG9naWMgaGlkZSB2b2NhYnVsYXJ5LXVyaSBhbmQgY29kZXMgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUudGFnVm9jYWJ1bGFyeUhpZGVGaWVsZCA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgdmFyIHRhZ192b2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3RbaWQqPVwidGFnX3ZvY2FidWxhcnlcIl0nKTtcbiAgICAgICAgaWYgKHRhZ192b2NhYnVsYXJ5Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuZWFjaCh0YWdfdm9jYWJ1bGFyeSwgZnVuY3Rpb24gKGluZGV4LCB0YWcpIHtcbiAgICAgICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSAoX2EgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFnKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJzEnO1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVUYWdGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFnKSwgZGF0YS50b1N0cmluZygpKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgdGFnX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IGUucGFyYW1zLmRhdGEuaWQ7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVUYWdGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgZGF0YSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIHRhZ192b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVRhZ0ZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCAnJyk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogSGlkZSBUYWcgRm9ybSBmaWVsZHNcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmhpZGVUYWdGaWVsZCA9IGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcbiAgICAgICAgdmFyIGNhc2UxX3Nob3cgPSAnaW5wdXRbaWQqPVwiW3RhZ190ZXh0XVwiXScsIGNhc2UyX3Nob3cgPSAnc2VsZWN0W2lkKj1cIltnb2Fsc190YWdfY29kZV1cIl0nLCBjYXNlM19zaG93ID0gJ3NlbGVjdFtpZCo9XCJbdGFyZ2V0c190YWdfY29kZV1cIl0nLCBjYXNlOTlfc2hvdyA9ICdpbnB1dFtpZCo9XCJbdGFnX3RleHRdXCJdLCBpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdJywgY2FzZTEgPSAnc2VsZWN0W2lkKj1cIltnb2Fsc190YWdfY29kZV1cIl0sc2VsZWN0W2lkKj1cIlt0YXJnZXRzX3RhZ19jb2RlXVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdJywgY2FzZTIgPSAnaW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSxzZWxlY3RbaWQqPVwiW3RhcmdldHNfdGFnX2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbdGFyZ2V0c190YWdfY29kZV1cIl0saW5wdXRbaWQqPVwiW3RhZ190ZXh0XVwiXScsIGNhc2UzID0gJ2lucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0sc2VsZWN0W2lkKj1cIltnb2Fsc190YWdfY29kZV1cIl0saW5wdXRbaWQqPVwiW3RhZ190ZXh0XVwiXScsIGNhc2U5OSA9ICdzZWxlY3RbaWQqPVwiW2dvYWxzX3RhZ19jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW3RhcmdldHNfdGFnX2NvZGVdXCJdJztcbiAgICAgICAgc3dpdGNoICh2YWx1ZSkge1xuICAgICAgICAgICAgY2FzZSAnMSc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTFfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTEpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzInOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICczJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlM19zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMylcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnOTknOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U5OV9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOTkpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGRlZmF1bHQ6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTFfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTEpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgcmV0dXJuIER5bmFtaWNGaWVsZDtcbn0oKSk7XG5leHBvcnRzLkR5bmFtaWNGaWVsZCA9IER5bmFtaWNGaWVsZDtcbiIsIlwidXNlIHN0cmljdFwiO1xudmFyIF9faW1wb3J0RGVmYXVsdCA9ICh0aGlzICYmIHRoaXMuX19pbXBvcnREZWZhdWx0KSB8fCBmdW5jdGlvbiAobW9kKSB7XG4gICAgcmV0dXJuIChtb2QgJiYgbW9kLl9fZXNNb2R1bGUpID8gbW9kIDogeyBcImRlZmF1bHRcIjogbW9kIH07XG59O1xuT2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFwiX19lc01vZHVsZVwiLCB7IHZhbHVlOiB0cnVlIH0pO1xudmFyIGF4aW9zXzEgPSBfX2ltcG9ydERlZmF1bHQocmVxdWlyZShcImF4aW9zXCIpKTtcbnZhciBqcXVlcnlfMSA9IF9faW1wb3J0RGVmYXVsdChyZXF1aXJlKFwianF1ZXJ5XCIpKTtcbnJlcXVpcmUoXCJzZWxlY3QyXCIpO1xudmFyIER5bmFtaWNGaWVsZF8xID0gcmVxdWlyZShcIi4vRHluYW1pY0ZpZWxkXCIpO1xudmFyIGR5bmFtaWNGaWVsZCA9IG5ldyBEeW5hbWljRmllbGRfMS5EeW5hbWljRmllbGQoKTtcbnZhciBGb3JtQnVpbGRlciA9IC8qKiBAY2xhc3MgKi8gKGZ1bmN0aW9uICgpIHtcbiAgICBmdW5jdGlvbiBGb3JtQnVpbGRlcigpIHtcbiAgICB9XG4gICAgLy8gYWRkcyBuZXcgY29sbGVjdGlvbiBvZiBzdWItZWxlbWVudFxuICAgIEZvcm1CdWlsZGVyLnByb3RvdHlwZS5hZGRGb3JtID0gZnVuY3Rpb24gKGV2KSB7XG4gICAgICAgIGV2LnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIHZhciB0YXJnZXQgPSBldi50YXJnZXQ7XG4gICAgICAgIHZhciBjb250YWluZXIgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdmb3JtX3R5cGUnKVxuICAgICAgICAgICAgPyAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoXCIuY29sbGVjdGlvbi1jb250YWluZXJbZm9ybV90eXBlID0nXCIuY29uY2F0KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2Zvcm1fdHlwZScpLCBcIiddXCIpKVxuICAgICAgICAgICAgOiAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5jb2xsZWN0aW9uLWNvbnRhaW5lcicpO1xuICAgICAgICB2YXIgY291bnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdjaGlsZF9jb3VudCcpXG4gICAgICAgICAgICA/IHBhcnNlSW50KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2NoaWxkX2NvdW50JykpICsgMVxuICAgICAgICAgICAgOiAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wYXJlbnQoKS5maW5kKCcuZm9ybS1jaGlsZC1ib2R5JykubGVuZ3RoO1xuICAgICAgICB2YXIgcGFyZW50X2NvdW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cigncGFyZW50X2NvdW50JylcbiAgICAgICAgICAgID8gcGFyc2VJbnQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cigncGFyZW50X2NvdW50JykpXG4gICAgICAgICAgICA6ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLnBhcmVudHMoJy5tdWx0aS1mb3JtJykuaW5kZXgoKSAtIDE7XG4gICAgICAgIHZhciB3cmFwcGVyX3BhcmVudF9jb3VudCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ3dyYXBwZWRfcGFyZW50X2NvdW50JylcbiAgICAgICAgICAgID8gcGFyc2VJbnQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignd3JhcHBlZF9wYXJlbnRfY291bnQnKSlcbiAgICAgICAgICAgIDogKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucGFyZW50cygnLndyYXBwZWQtY2hpbGQtYm9keScpLmluZGV4KCkgLSAxO1xuICAgICAgICB2YXIgcHJvdG8gPSBjb250YWluZXJcbiAgICAgICAgICAgIC5kYXRhKCdwcm90b3R5cGUnKVxuICAgICAgICAgICAgLnJlcGxhY2UoL19fUEFSRU5UX05BTUVfXy9nLCBwYXJlbnRfY291bnQpO1xuICAgICAgICBpZiAoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignaGFzX2NoaWxkX2NvbGxlY3Rpb24nKSkge1xuICAgICAgICAgICAgcHJvdG8gPSBwcm90by5yZXBsYWNlKC9fX1dSQVBQRVJfTkFNRV9fL2csIGNvdW50KTtcbiAgICAgICAgICAgIHByb3RvID0gcHJvdG8ucmVwbGFjZSgvX19OQU1FX18vZywgMCk7XG4gICAgICAgIH1cbiAgICAgICAgZWxzZSB7XG4gICAgICAgICAgICBwcm90byA9IHByb3RvLnJlcGxhY2UoL19fTkFNRV9fL2csIGNvdW50KTtcbiAgICAgICAgICAgIHByb3RvID0gcHJvdG8ucmVwbGFjZSgvX19XUkFQUEVSX05BTUVfXy9nLCB3cmFwcGVyX3BhcmVudF9jb3VudCk7XG4gICAgICAgIH1cbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucHJldigpLmFwcGVuZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkocHJvdG8pKTtcbiAgICAgICAgaWYgKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2hhc19jaGlsZF9jb2xsZWN0aW9uJykpIHtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXG4gICAgICAgICAgICAgICAgLnByZXYoJy5zdWJlbGVtZW50JylcbiAgICAgICAgICAgICAgICAuY2hpbGRyZW4oJy53cmFwcGVkLWNoaWxkLWJvZHknKVxuICAgICAgICAgICAgICAgIC5sYXN0KClcbiAgICAgICAgICAgICAgICAuZmluZCgnLmFkZF90b19jb2xsZWN0aW9uJylcbiAgICAgICAgICAgICAgICAuYXR0cignd3JhcHBlZF9wYXJlbnRfY291bnQnLCBjb3VudCk7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KVxuICAgICAgICAgICAgICAgIC5wcmV2KCcuc3ViZWxlbWVudCcpXG4gICAgICAgICAgICAgICAgLmNoaWxkcmVuKCcud3JhcHBlZC1jaGlsZC1ib2R5JylcbiAgICAgICAgICAgICAgICAubGFzdCgpXG4gICAgICAgICAgICAgICAgLmZpbmQoJy5hZGRfdG9fY29sbGVjdGlvbicpXG4gICAgICAgICAgICAgICAgLmF0dHIoJ3BhcmVudF9jb3VudCcsIHBhcmVudF9jb3VudCk7XG4gICAgICAgIH1cbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldClcbiAgICAgICAgICAgIC5wcmV2KClcbiAgICAgICAgICAgIC5maW5kKCcud3JhcHBlZC1jaGlsZC1ib2R5JylcbiAgICAgICAgICAgIC5sYXN0KClcbiAgICAgICAgICAgIC5maW5kKCcuYWRkX3RvX2NvbGxlY3Rpb24nKVxuICAgICAgICAgICAgLmF0dHIoJ3dyYXBwZXJfcGFyZW50X2NvdW50Jywgd3JhcHBlcl9wYXJlbnRfY291bnQgIT09IG51bGwgJiYgd3JhcHBlcl9wYXJlbnRfY291bnQgIT09IHZvaWQgMCA/IHdyYXBwZXJfcGFyZW50X2NvdW50IDogMCk7XG4gICAgICAgIGlmICgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdmb3JtX3R5cGUnKSkge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucHJldigpLmxhc3QoKS5maW5kKCcuc2VsZWN0MicpLnNlbGVjdDIoe1xuICAgICAgICAgICAgICAgIHBsYWNlaG9sZGVyOiAnU2VsZWN0IGFuIG9wdGlvbicsXG4gICAgICAgICAgICAgICAgYWxsb3dDbGVhcjogdHJ1ZSxcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpXG4gICAgICAgICAgICAgICAgLmZpbmQoJy5zdWItYXR0cmlidXRlJylcbiAgICAgICAgICAgICAgICAud3JhcEFsbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJzxkaXYgY2xhc3M9XCJmb3JtLWZpZWxkLWdyb3VwIGZsZXggZmxleC13cmFwIHJvdW5kZWQtYnItbGcgYm9yZGVyLXkgYm9yZGVyLXIgYm9yZGVyLXNwcmluZy01MCBzdWItYXR0cmlidXRlLXdyYXBwZXJcIj48L2Rpdj4nKSk7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KVxuICAgICAgICAgICAgICAgIC5wcmV2KCcuc3ViZWxlbWVudCcpXG4gICAgICAgICAgICAgICAgLmNoaWxkcmVuKCcud3JhcHBlZC1jaGlsZC1ib2R5JylcbiAgICAgICAgICAgICAgICAubGFzdCgpXG4gICAgICAgICAgICAgICAgLmZpbmQoJy5zdWItYXR0cmlidXRlJylcbiAgICAgICAgICAgICAgICAud3JhcEFsbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJzxkaXYgY2xhc3M9XCJmb3JtLWZpZWxkLWdyb3VwIGZsZXggZmxleC13cmFwIHJvdW5kZWQtYnItbGcgYm9yZGVyLXkgYm9yZGVyLXIgYm9yZGVyLXNwcmluZy01MCBzdWItYXR0cmlidXRlLXdyYXBwZXIgbXQtNlwiPjwvZGl2PicpKTtcbiAgICAgICAgfVxuICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXG4gICAgICAgICAgICAgICAgLnBhcmVudCgpXG4gICAgICAgICAgICAgICAgLmZpbmQoJy5mb3JtLWNoaWxkLWJvZHknKVxuICAgICAgICAgICAgICAgIC5sYXN0KClcbiAgICAgICAgICAgICAgICAuZmluZCgnLnNlbGVjdDInKVxuICAgICAgICAgICAgICAgIC5zZWxlY3QyKHtcbiAgICAgICAgICAgICAgICBwbGFjZWhvbGRlcjogJ1NlbGVjdCBhbiBvcHRpb24nLFxuICAgICAgICAgICAgICAgIGFsbG93Q2xlYXI6IHRydWUsXG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdjaGlsZF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgZHluYW1pY0ZpZWxkLmFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC5zZWN0b3JWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgfTtcbiAgICAvLyBhZGRzIHBhcmVudCBjb2xsZWN0aW9uXG4gICAgRm9ybUJ1aWxkZXIucHJvdG90eXBlLmFkZFBhcmVudEZvcm0gPSBmdW5jdGlvbiAoZXYpIHtcbiAgICAgICAgZXYucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgdmFyIHRhcmdldCA9IGV2LnRhcmdldDtcbiAgICAgICAgdmFyIGNvbnRhaW5lciA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2Zvcm1fdHlwZScpXG4gICAgICAgICAgICA/ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShcIi5wYXJlbnQtY29sbGVjdGlvbltmb3JtX3R5cGUgPSdcIi5jb25jYXQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignZm9ybV90eXBlJyksIFwiJ11cIikpXG4gICAgICAgICAgICA6ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLnBhcmVudC1jb2xsZWN0aW9uJyk7XG4gICAgICAgIHZhciBjb3VudCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ3BhcmVudF9jb3VudCcpXG4gICAgICAgICAgICA/IHBhcnNlSW50KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ3BhcmVudF9jb3VudCcpKSArIDFcbiAgICAgICAgICAgIDogKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLnByZXYoKS5maW5kKCcubXVsdGktZm9ybScpLmxlbmd0aFxuICAgICAgICAgICAgICAgID8gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucHJldigpLmZpbmQoJy5tdWx0aS1mb3JtJykubGVuZ3RoXG4gICAgICAgICAgICAgICAgOiAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wcmV2KCkuZmluZCgnLndyYXBwZWQtY2hpbGQtYm9keScpLmxlbmd0aCkgKyAxO1xuICAgICAgICB2YXIgcHJvdG8gPSBjb250YWluZXIuZGF0YSgncHJvdG90eXBlJykucmVwbGFjZSgvX19QQVJFTlRfTkFNRV9fL2csIGNvdW50KTtcbiAgICAgICAgcHJvdG8gPSBwcm90by5yZXBsYWNlKC9fX05BTUVfXy9nLCAwKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucHJldigpLmFwcGVuZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkocHJvdG8pKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucHJldigpLmZpbmQoJy5tdWx0aS1mb3JtJykubGFzdCgpLmZpbmQoJy5zZWxlY3QyJykuc2VsZWN0Mih7XG4gICAgICAgICAgICBwbGFjZWhvbGRlcjogJ1NlbGVjdCBhbiBvcHRpb24nLFxuICAgICAgICAgICAgYWxsb3dDbGVhcjogdHJ1ZSxcbiAgICAgICAgfSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXG4gICAgICAgICAgICAucHJldigpXG4gICAgICAgICAgICAuZmluZCgnLm11bHRpLWZvcm0nKVxuICAgICAgICAgICAgLmxhc3QoKVxuICAgICAgICAgICAgLmZpbmQoJy5hZGRfdG9fY29sbGVjdGlvbicpXG4gICAgICAgICAgICAuYXR0cigncGFyZW50X2NvdW50JywgY291bnQpO1xuICAgICAgICB0aGlzLmFkZFdyYXBwZXJPbkFkZCh0YXJnZXQpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdwYXJlbnRfY291bnQnLCBjb3VudCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC5odW1hbml0YXJpYW5TY29wZUhpZGVWb2NhYnVsYXJ5VXJpKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC5jb3VudHJ5QnVkZ2V0SGlkZUNvZGVGaWVsZCgpO1xuICAgICAgICBkeW5hbWljRmllbGQuc2VjdG9yVm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICBkeW5hbWljRmllbGQucmVjaXBpZW50Vm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICBkeW5hbWljRmllbGQucG9saWN5Vm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICBkeW5hbWljRmllbGQudGFnVm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICBkeW5hbWljRmllbGQudHJhbnNhY3Rpb25BaWRUeXBlVm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICBkeW5hbWljRmllbGQuaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkVXJpKCk7XG4gICAgfTtcbiAgICAvLyBkZWxldGVzIGNvbGxlY3Rpb25cbiAgICBGb3JtQnVpbGRlci5wcm90b3R5cGUuZGVsZXRlRm9ybSA9IGZ1bmN0aW9uIChldikge1xuICAgICAgICBldi5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICB2YXIgdGFyZ2V0ID0gZXYudGFyZ2V0O1xuICAgICAgICB2YXIgY29sbGVjdGlvbkxlbmd0aCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLm11bHRpLWZvcm0nKS5sZW5ndGhcbiAgICAgICAgICAgID8gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuY2xvc2VzdCgnLnN1YmVsZW1lbnQnKS5maW5kKCcuZm9ybS1jaGlsZC1ib2R5JykubGVuZ3RoXG4gICAgICAgICAgICA6ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmZvcm0tY2hpbGQtYm9keScpLmxlbmd0aDtcbiAgICAgICAgdmFyIGNvdW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX2NvbGxlY3Rpb24nKS5hdHRyKCdjaGlsZF9jb3VudCcpXG4gICAgICAgICAgICA/IHBhcnNlSW50KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmFkZF90b19jb2xsZWN0aW9uJykuYXR0cignY2hpbGRfY291bnQnKSkgKyAxXG4gICAgICAgICAgICA6IGNvbGxlY3Rpb25MZW5ndGg7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmFkZF90b19jb2xsZWN0aW9uJykuYXR0cignY2hpbGRfY291bnQnLCBjb3VudCk7XG4gICAgICAgIGlmIChjb2xsZWN0aW9uTGVuZ3RoID4gMSkge1xuICAgICAgICAgICAgdmFyIHRnID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuY2xvc2VzdCgnLmZvcm0tY2hpbGQtYm9keScpO1xuICAgICAgICAgICAgdGcubmV4dCgnLmVycm9yJykucmVtb3ZlKCk7XG4gICAgICAgICAgICB0Zy5yZW1vdmUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLy8gZGVsZXRlcyBwYXJlbnQgY29sbGVjdGlvblxuICAgIEZvcm1CdWlsZGVyLnByb3RvdHlwZS5kZWxldGVQYXJlbnRGb3JtID0gZnVuY3Rpb24gKGV2KSB7XG4gICAgICAgIGV2LnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIHZhciB0YXJnZXQgPSBldi50YXJnZXQ7XG4gICAgICAgIHZhciBjb2xsZWN0aW9uTGVuZ3RoID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuc3ViZWxlbWVudCcpLmxlbmd0aDtcbiAgICAgICAgdmFyIGNvdW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX3BhcmVudCcpLmF0dHIoJ2NoaWxkX2NvdW50JylcbiAgICAgICAgICAgID8gcGFyc2VJbnQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX3BhcmVudCcpLmF0dHIoJ2NoaWxkX2NvdW50JykpICsgMVxuICAgICAgICAgICAgOiBjb2xsZWN0aW9uTGVuZ3RoO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5hZGRfdG9fcGFyZW50JykuYXR0cignY2hpbGRfY291bnQnLCBjb3VudCk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmFkZF90b19wYXJlbnQnKS5hdHRyKCdwYXJlbnRfY291bnQnLCBjb3VudCk7XG4gICAgICAgIGlmIChjb2xsZWN0aW9uTGVuZ3RoID4gMikge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucGFyZW50KCkucmVtb3ZlKCk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8vYWRkIHdyYXBwZXIgZGl2IGFyb3VuZCB0aGUgYXR0cmlidXRlc1xuICAgIEZvcm1CdWlsZGVyLnByb3RvdHlwZS5hZGRXcmFwcGVyID0gZnVuY3Rpb24gKCkge1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5tdWx0aS1mb3JtJykuZWFjaChmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcbiAgICAgICAgICAgICAgICAuZmluZCgnLmF0dHJpYnV0ZScpXG4gICAgICAgICAgICAgICAgLndyYXBBbGwoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCc8ZGl2IGNsYXNzPVwiZm9ybS1maWVsZC1ncm91cCBmbGV4IGZsZXgtd3JhcCByb3VuZGVkLWJyLWxnIGJvcmRlci15IGJvcmRlci1yIGJvcmRlci1zcHJpbmctNTAgYXR0cmlidXRlLXdyYXBwZXIgbWItNFwiPjwvZGl2PicpKTtcbiAgICAgICAgfSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLnN1YmVsZW1lbnQnKVxuICAgICAgICAgICAgLmZpbmQoJy53cmFwcGVkLWNoaWxkLWJvZHknKVxuICAgICAgICAgICAgLmVhY2goZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpXG4gICAgICAgICAgICAgICAgLmZpbmQoJy5zdWItYXR0cmlidXRlJylcbiAgICAgICAgICAgICAgICAud3JhcEFsbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJzxkaXYgY2xhc3M9XCJmb3JtLWZpZWxkLWdyb3VwIGZsZXggZmxleC13cmFwIHJvdW5kZWQtYnItbGcgYm9yZGVyLXkgYm9yZGVyLXIgYm9yZGVyLXNwcmluZy01MCBzdWItYXR0cmlidXRlLXdyYXBwZXIgbWItNFwiPjwvZGl2PicpKTtcbiAgICAgICAgfSk7XG4gICAgICAgIHZhciBmb3JtRmllbGQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2Zvcm0+LmZvcm0tZmllbGQnKTtcbiAgICAgICAgaWYgKGZvcm1GaWVsZC5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBmb3JtRmllbGQud3JhcEFsbCgnPGRpdiBjbGFzcz1cImZvcm0tZmllbGQtZ3JvdXAtb3V0ZXIgZ3JpZCB4bDpncmlkLWNvbHMtMiBtYi02IC1teC0zIGdhcC15LTZcIj48L2Rpdj4nKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgRm9ybUJ1aWxkZXIucHJvdG90eXBlLmFkZFdyYXBwZXJPbkFkZCA9IGZ1bmN0aW9uICh0YXJnZXQpIHtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldClcbiAgICAgICAgICAgIC5wcmV2KClcbiAgICAgICAgICAgIC5maW5kKCcubXVsdGktZm9ybScpXG4gICAgICAgICAgICAubGFzdCgpXG4gICAgICAgICAgICAuZmluZCgnLmF0dHJpYnV0ZScpXG4gICAgICAgICAgICAud3JhcEFsbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJzxkaXYgY2xhc3M9XCJmb3JtLWZpZWxkLWdyb3VwIGdyaWQgeGw6Z3JpZC1jb2xzLTIgcm91bmRlZC1ici1sZyBib3JkZXIteSBib3JkZXItciBib3JkZXItc3ByaW5nLTUwIGF0dHJpYnV0ZS13cmFwcGVyIG1iLTRcIj48L2Rpdj4nKSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXG4gICAgICAgICAgICAucHJldigpXG4gICAgICAgICAgICAuZmluZCgnLm11bHRpLWZvcm0nKVxuICAgICAgICAgICAgLmxhc3QoKVxuICAgICAgICAgICAgLmZpbmQoJy5zdWJlbGVtZW50JylcbiAgICAgICAgICAgIC5maW5kKCcud3JhcHBlZC1jaGlsZC1ib2R5JylcbiAgICAgICAgICAgIC5lYWNoKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKVxuICAgICAgICAgICAgICAgIC5maW5kKCcuc3ViLWF0dHJpYnV0ZScpXG4gICAgICAgICAgICAgICAgLndyYXBBbGwoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCc8ZGl2IGNsYXNzPVwiZm9ybS1maWVsZC1ncm91cCBmbGV4IGZsZXgtd3JhcCByb3VuZGVkLWJyLWxnIGJvcmRlci15IGJvcmRlci1yIGJvcmRlci1zcHJpbmctNTAgc3ViLWF0dHJpYnV0ZS13cmFwcGVyIG1iLTRcIj48L2Rpdj4nKSk7XG4gICAgICAgIH0pO1xuICAgIH07XG4gICAgRm9ybUJ1aWxkZXIucHJvdG90eXBlLnRleHRBcmVhSGVpZ2h0ID0gZnVuY3Rpb24gKGV2KSB7XG4gICAgICAgIHZhciB0YXJnZXQgPSBldi50YXJnZXQ7XG4gICAgICAgIHZhciBoZWlnaHQgPSB0YXJnZXQuc2Nyb2xsSGVpZ2h0O1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5jc3MoJ2hlaWdodCcsIGhlaWdodCk7XG4gICAgfTtcbiAgICBGb3JtQnVpbGRlci5wcm90b3R5cGUuYWRkVG9Db2xsZWN0aW9uID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCAnLmFkZF90b19jb2xsZWN0aW9uJywgZnVuY3Rpb24gKGV2ZW50KSB7XG4gICAgICAgICAgICBpZiAoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGV2ZW50LnRhcmdldCkuaGFzQ2xhc3MoJ2FkZC1pY29uJykpIHtcbiAgICAgICAgICAgICAgICBldmVudC5zdG9wUHJvcGFnYXRpb24oKTtcbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoZXZlbnQudGFyZ2V0KVxuICAgICAgICAgICAgICAgICAgICAucGFyZW50KCdidXR0b24nKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2xpY2snKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgICAgIF90aGlzLmFkZEZvcm0oZXZlbnQpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX3BhcmVudCcpLm9uKCdjbGljaycsIGZ1bmN0aW9uIChldmVudCkge1xuICAgICAgICAgICAgaWYgKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShldmVudC50YXJnZXQpLmhhc0NsYXNzKCdhZGQtaWNvbicpKSB7XG4gICAgICAgICAgICAgICAgZXZlbnQuc3RvcFByb3BhZ2F0aW9uKCk7XG4gICAgICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGV2ZW50LnRhcmdldClcbiAgICAgICAgICAgICAgICAgICAgLnBhcmVudCgnYnV0dG9uJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NsaWNrJyk7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgICAgICBfdGhpcy5hZGRQYXJlbnRGb3JtKGV2ZW50KTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSk7XG4gICAgfTtcbiAgICBGb3JtQnVpbGRlci5wcm90b3R5cGUuZGVsZXRlQ29sbGVjdGlvbiA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgdmFyIGRlbGV0ZUNvbmZpcm1hdGlvbiA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmRlbGV0ZS1jb25maXJtYXRpb24nKSwgY2FuY2VsUG9wdXAgPSAnLmNhbmNlbC1wb3B1cCcsIGRlbGV0ZUNvbmZpcm0gPSAnLmRlbGV0ZS1jb25maXJtJztcbiAgICAgICAgdmFyIGRlbGV0ZUluZGV4ID0ge30sIGNoaWxkT3JQYXJlbnQgPSAnJztcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgJy5kZWxldGUnLCBmdW5jdGlvbiAoZXZlbnQpIHtcbiAgICAgICAgICAgIGRlbGV0ZUNvbmZpcm1hdGlvbi5mYWRlSW4oKTtcbiAgICAgICAgICAgIGRlbGV0ZUluZGV4ID0gZXZlbnQ7XG4gICAgICAgICAgICBjaGlsZE9yUGFyZW50ID0gJ2NoaWxkJztcbiAgICAgICAgfSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsIGNhbmNlbFBvcHVwLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICBkZWxldGVDb25maXJtYXRpb24uZmFkZU91dCgpO1xuICAgICAgICAgICAgZGVsZXRlSW5kZXggPSB7fTtcbiAgICAgICAgICAgIGNoaWxkT3JQYXJlbnQgPSAnJztcbiAgICAgICAgfSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsIGRlbGV0ZUNvbmZpcm0sIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgIGlmIChjaGlsZE9yUGFyZW50ID09PSAnY2hpbGQnKSB7XG4gICAgICAgICAgICAgICAgX3RoaXMuZGVsZXRlRm9ybShkZWxldGVJbmRleCk7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBlbHNlIGlmIChjaGlsZE9yUGFyZW50ID09PSAncGFyZW50Jykge1xuICAgICAgICAgICAgICAgIF90aGlzLmRlbGV0ZVBhcmVudEZvcm0oZGVsZXRlSW5kZXgpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZGVsZXRlQ29uZmlybWF0aW9uLmZhZGVPdXQoKTtcbiAgICAgICAgICAgIGRlbGV0ZUluZGV4ID0ge307XG4gICAgICAgICAgICBjaGlsZE9yUGFyZW50ID0gJyc7XG4gICAgICAgIH0pO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCAnLmRlbGV0ZS1wYXJlbnQnLCBmdW5jdGlvbiAoZXZlbnQpIHtcbiAgICAgICAgICAgIGRlbGV0ZUNvbmZpcm1hdGlvbi5mYWRlSW4oKTtcbiAgICAgICAgICAgIGRlbGV0ZUluZGV4ID0gZXZlbnQ7XG4gICAgICAgICAgICBjaGlsZE9yUGFyZW50ID0gJ3BhcmVudCc7XG4gICAgICAgIH0pO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5zZWxlY3QyJykuc2VsZWN0Mih7XG4gICAgICAgICAgICBwbGFjZWhvbGRlcjogJ1NlbGVjdCBhbiBvcHRpb24nLFxuICAgICAgICAgICAgYWxsb3dDbGVhcjogdHJ1ZSxcbiAgICAgICAgfSk7XG4gICAgICAgIC8vIHVwZGF0ZSBmb3JtYXQgb24gY2hhbmdlIG9mIGRvY3VtZW50IGxpbmtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2tleXVwJywgJ2lucHV0W2lkKj1cIlt1cmxdXCJdJywgZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgIHZhciBmaWxlUGF0aCA9ICgoX2EgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcnKS50b1N0cmluZygpO1xuICAgICAgICAgICAgdmFyIHVybCA9IFwiL21pbWV0eXBlP3VybD1cIi5jb25jYXQoZmlsZVBhdGgsIFwiJnR5cGU9dXJsXCIpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJykuZmluZCgnLnRleHQtZGFuZ2VyJykucmVtb3ZlKCk7XG4gICAgICAgICAgICBpZiAoZmlsZVBhdGggIT09ICcnKSB7XG4gICAgICAgICAgICAgICAgYXhpb3NfMS5kZWZhdWx0LmdldCh1cmwpLnRoZW4oZnVuY3Rpb24gKHJlc3BvbnNlKSB7XG4gICAgICAgICAgICAgICAgICAgIGlmIChyZXNwb25zZS5kYXRhLnN1Y2Nlc3MpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBmb3JtYXQgPSByZXNwb25zZS5kYXRhLmRhdGEubWltZXR5cGU7XG4gICAgICAgICAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoX3RoaXMpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAuZmluZCgnc2VsZWN0W2lkKj1cIltmb3JtYXRdXCJdJylcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAudmFsKGZvcm1hdClcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJyk7XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgZWxzZSB7XG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgbWVzc2FnZSA9IFwiPGRpdiBjbGFzcz0ndGV4dC1kYW5nZXIgZXJyb3InPlwiICsgcmVzcG9uc2UuZGF0YS5tZXNzYWdlICsgXCI8L2Rpdj5cIjtcbiAgICAgICAgICAgICAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShfdGhpcykuY2xvc2VzdCgnLmZvcm0tZmllbGQnKS5hcHBlbmQoXCI8ZGl2IGNsYXNzPSd0ZXh0LWRhbmdlciBlcnJvcic+XCIgKyByZXNwb25zZS5kYXRhLm1lc3NhZ2UgKyBcIjwvZGl2PlwiKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKG1lc3NhZ2UpO1xuICAgICAgICAgICAgICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKF90aGlzKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLmZpbmQoJ3NlbGVjdFtpZCo9XCJbZm9ybWF0XVwiXScpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJyk7XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoJ2lucHV0W2lkKj1cIltkb2N1bWVudF1cIl0nKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJyk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH0pO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2hhbmdlJywgJ2lucHV0W2lkKj1cIltkb2N1bWVudF1cIl0nLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuICAgICAgICAgICAgdmFyIF9hO1xuICAgICAgICAgICAgY29uc29sZS5sb2coJ2NoYW5nZWQnKTtcbiAgICAgICAgICAgIHZhciBmaWxlUGF0aCA9ICgoX2EgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcnKS50b1N0cmluZygpO1xuICAgICAgICAgICAgdmFyIHVybCA9IFwiL21pbWV0eXBlP3VybD1cIi5jb25jYXQoZmlsZVBhdGgsIFwiJiZ0eXBlPWRvY3VtZW50XCIpO1xuICAgICAgICAgICAgaWYgKGZpbGVQYXRoICE9PSAnJykge1xuICAgICAgICAgICAgICAgIGF4aW9zXzEuZGVmYXVsdC5nZXQodXJsKS50aGVuKGZ1bmN0aW9uIChyZXNwb25zZSkge1xuICAgICAgICAgICAgICAgICAgICBpZiAocmVzcG9uc2UuZGF0YS5zdWNjZXNzKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgZm9ybWF0ID0gcmVzcG9uc2UuZGF0YS5kYXRhLm1pbWV0eXBlO1xuICAgICAgICAgICAgICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKF90aGlzKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLmZpbmQoJ3NlbGVjdFtpZCo9XCJbZm9ybWF0XVwiXScpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLnZhbChmb3JtYXQpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKF90aGlzKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLmZpbmQoJ3NlbGVjdFtpZCo9XCJbZm9ybWF0XVwiXScpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJyk7XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoJ2lucHV0W2lkKj1cIlt1cmxdXCJdJylcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZWxzZSB7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgIC5maW5kKCdzZWxlY3RbaWQqPVwiW2Zvcm1hdF1cIl0nKVxuICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpO1xuICAgICAgICB9KTtcbiAgICB9O1xuICAgIHJldHVybiBGb3JtQnVpbGRlcjtcbn0oKSk7XG4oMCwganF1ZXJ5XzEuZGVmYXVsdCkoZnVuY3Rpb24gKCkge1xuICAgIHZhciBmb3JtQnVpbGRlciA9IG5ldyBGb3JtQnVpbGRlcigpO1xuICAgIGZvcm1CdWlsZGVyLmFkZFdyYXBwZXIoKTtcbiAgICBkeW5hbWljRmllbGQuaGlkZVNob3dGb3JtRmllbGRzKCk7XG4gICAgZHluYW1pY0ZpZWxkLnVwZGF0ZUFjdGl2aXR5SWRlbnRpZmllcigpO1xuICAgIGZvcm1CdWlsZGVyLmFkZFRvQ29sbGVjdGlvbigpO1xuICAgIGZvcm1CdWlsZGVyLmRlbGV0ZUNvbGxlY3Rpb24oKTtcbiAgICAvKipcbiAgICAgKiBUZXh0IGFyZWEgaGVpZ2h0IG9uIHR5cGluZ1xuICAgICAqL1xuICAgIHZhciB0ZXh0QXJlYVRhcmdldCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgndGV4dGFyZWEuZm9ybV9faW5wdXQnKTtcbiAgICBpZiAodGV4dEFyZWFUYXJnZXQubGVuZ3RoID4gMCkge1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignaW5wdXQnLCAndGV4dGFyZWEuZm9ybV9faW5wdXQnLCBmdW5jdGlvbiAoZXZlbnQpIHtcbiAgICAgICAgICAgIGZvcm1CdWlsZGVyLnRleHRBcmVhSGVpZ2h0KGV2ZW50KTtcbiAgICAgICAgfSk7XG4gICAgfVxuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdzZWxlY3QyOm9wZW4nLCAnLnNlbGVjdDInLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBzZWxlY3Rfc2VhcmNoID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLnNlbGVjdDItc2VhcmNoX19maWVsZCcpO1xuICAgICAgICBpZiAoc2VsZWN0X3NlYXJjaCkge1xuICAgICAgICAgICAgc2VsZWN0X3NlYXJjaC5mb2N1cygpO1xuICAgICAgICB9XG4gICAgfSk7XG4gICAgLyoqXG4gICAgICogY2hlY2tzIHJlZ2lzdHJhdGlvbiBhZ2VuY3ksIGNvdW50cnkgYW5kIHJlZ2lzdHJhdGlvbiBudW1iZXIgdG8gZGVkdWNlIGlkZW50aWZpZXJcbiAgICAgKi9cbiAgICB1cGRhdGVSZWdpc3RyYXRpb25BZ2VuY3koKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjb3JnYW5pemF0aW9uX2NvdW50cnknKSk7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjb3JnYW5pc2F0aW9uX2lkZW50aWZpZXInKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpO1xuICAgIGZ1bmN0aW9uIHVwZGF0ZVJlZ2lzdHJhdGlvbkFnZW5jeShjb3VudHJ5KSB7XG4gICAgICAgIGlmIChjb3VudHJ5LnZhbCgpKSB7XG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmFqYXgoeyB1cmw6ICcvb3JnYW5pc2F0aW9uL2FnZW5jeS8nICsgY291bnRyeS52YWwoKSB9KS50aGVuKGZ1bmN0aW9uIChyZXNwb25zZSkge1xuICAgICAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgICAgICB2YXIgY3VycmVudF92YWwgPSAoX2EgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScpLnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnJztcbiAgICAgICAgICAgICAgICB2YXIgdmFsID0gZmFsc2U7XG4gICAgICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjb3JnYW5pemF0aW9uX3JlZ2lzdHJhdGlvbl9hZ2VuY3knKS5lbXB0eSgpO1xuICAgICAgICAgICAgICAgIGZvciAodmFyIGRhdGEgaW4gcmVzcG9uc2UuZGF0YSkge1xuICAgICAgICAgICAgICAgICAgICBpZiAoZGF0YSA9PT0gY3VycmVudF92YWwpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhbCA9IHRydWU7XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjb3JnYW5pemF0aW9uX3JlZ2lzdHJhdGlvbl9hZ2VuY3knKVxuICAgICAgICAgICAgICAgICAgICAgICAgLmFwcGVuZChuZXcgT3B0aW9uKHJlc3BvbnNlLmRhdGFbZGF0YV0sIGRhdGEsIHRydWUsIHRydWUpKVxuICAgICAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjb3JnYW5pemF0aW9uX3JlZ2lzdHJhdGlvbl9hZ2VuY3knKVxuICAgICAgICAgICAgICAgICAgICAudmFsKHZhbCA/IGN1cnJlbnRfdmFsIDogJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfVxuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdzZWxlY3QyOnNlbGVjdCcsICcjb3JnYW5pemF0aW9uX2NvdW50cnknLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHVwZGF0ZVJlZ2lzdHJhdGlvbkFnZW5jeSgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykpO1xuICAgIH0pO1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdzZWxlY3QyOnNlbGVjdCcsICcjb3JnYW5pemF0aW9uX3JlZ2lzdHJhdGlvbl9hZ2VuY3knLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBpZGVudGlmaWVyID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpLnZhbCgpICsgJy0nICsgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjcmVnaXN0cmF0aW9uX251bWJlcicpLnZhbCgpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbmlzYXRpb25faWRlbnRpZmllcicpLnZhbChpZGVudGlmaWVyKTtcbiAgICB9KTtcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignc2VsZWN0MjpjbGVhcicsICcjb3JnYW5pemF0aW9uX3JlZ2lzdHJhdGlvbl9hZ2VuY3knLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBpZGVudGlmaWVyID0gJy0nICsgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjcmVnaXN0cmF0aW9uX251bWJlcicpLnZhbCgpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbmlzYXRpb25faWRlbnRpZmllcicpLnZhbChpZGVudGlmaWVyKTtcbiAgICB9KTtcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbigna2V5dXAnLCAnI3JlZ2lzdHJhdGlvbl9udW1iZXInLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBpZGVudGlmaWVyID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjb3JnYW5pemF0aW9uX3JlZ2lzdHJhdGlvbl9hZ2VuY3knKS52YWwoKSArICctJyArICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS52YWwoKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjb3JnYW5pc2F0aW9uX2lkZW50aWZpZXInKS52YWwoaWRlbnRpZmllcik7XG4gICAgfSk7XG4gICAgLy8gYWRkIGNsYXNzIHRvIHRpdGxlIG9mIGNvbGxlY3Rpb24gd2hlbiB2YWxpZGF0aW9uIGVycm9yIG9jY3VycyBvbiBjb2xsZWN0aW9uIGxldmVsXG4gICAgdmFyIHN1YmVsZW1lbnQgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuc3ViZWxlbWVudCcpO1xuICAgIGZvciAodmFyIGkgPSAwOyBpIDwgc3ViZWxlbWVudC5sZW5ndGg7IGkrKykge1xuICAgICAgICB2YXIgdGl0bGUgPSBzdWJlbGVtZW50W2ldLnF1ZXJ5U2VsZWN0b3IoJy5jb250cm9sLWxhYmVsJyk7XG4gICAgICAgIHZhciBlcnJvckNvbnRhaW5lciA9IHN1YmVsZW1lbnRbaV0ucXVlcnlTZWxlY3RvcignLmNvbGxlY3Rpb25fZXJyb3InKTtcbiAgICAgICAgdmFyIGNoaWxkQ291bnQgPSBlcnJvckNvbnRhaW5lciA9PT0gbnVsbCB8fCBlcnJvckNvbnRhaW5lciA9PT0gdm9pZCAwID8gdm9pZCAwIDogZXJyb3JDb250YWluZXIuY2hpbGRFbGVtZW50Q291bnQ7XG4gICAgICAgIGlmIChjaGlsZENvdW50ICYmIGNoaWxkQ291bnQgPiAwKSB7XG4gICAgICAgICAgICB0aXRsZSA9PT0gbnVsbCB8fCB0aXRsZSA9PT0gdm9pZCAwID8gdm9pZCAwIDogdGl0bGUuY2xhc3NMaXN0LmFkZCgnZXJyb3ItdGl0bGUnKTtcbiAgICAgICAgfVxuICAgIH1cbiAgICAvLyBBZGRpbmcgY3Vyc29yIG5vdCBhbGxvd2VkIHRvIDxzZWxlY3Q+IHdoZXJlIGVsZW1lbnRKc29uU2NoZW1hIHJlYWRfb25seSA6IHRydWVcbiAgICB2YXIgcmVhZE9ubHlTZWxlY3RzID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbChcInNlbGVjdC5jdXJzb3Itbm90LWFsbG93ZWRcIik7XG4gICAgZm9yICh2YXIgaSA9IDA7IGkgPCByZWFkT25seVNlbGVjdHMubGVuZ3RoOyBpKyspIHtcbiAgICAgICAgdmFyIHNlbGVjdCA9IHJlYWRPbmx5U2VsZWN0c1tpXTtcbiAgICAgICAgdmFyIHNlbGVjdEVsZW1lbnRQYXJlbnRXcmFwcGVyID0gc2VsZWN0Lm5leHRTaWJsaW5nO1xuICAgICAgICB2YXIgc2VsZWN0RWxlbWVudFBhcmVudCA9IHNlbGVjdEVsZW1lbnRQYXJlbnRXcmFwcGVyID09PSBudWxsIHx8IHNlbGVjdEVsZW1lbnRQYXJlbnRXcmFwcGVyID09PSB2b2lkIDAgPyB2b2lkIDAgOiBzZWxlY3RFbGVtZW50UGFyZW50V3JhcHBlci5maXJzdENoaWxkO1xuICAgICAgICB2YXIgc2VsZWN0RWxlbWVudCA9IHNlbGVjdEVsZW1lbnRQYXJlbnQgPT09IG51bGwgfHwgc2VsZWN0RWxlbWVudFBhcmVudCA9PT0gdm9pZCAwID8gdm9pZCAwIDogc2VsZWN0RWxlbWVudFBhcmVudC5maXJzdENoaWxkO1xuICAgICAgICBpZiAoc2VsZWN0RWxlbWVudCkge1xuICAgICAgICAgICAgc2VsZWN0RWxlbWVudC5zdHlsZS5jdXJzb3IgPSBcIm5vdC1hbGxvd2VkXCI7XG4gICAgICAgIH1cbiAgICB9XG59KTtcbiJdLCJuYW1lcyI6WyJfX2ltcG9ydERlZmF1bHQiLCJtb2QiLCJfX2VzTW9kdWxlIiwiT2JqZWN0IiwiZGVmaW5lUHJvcGVydHkiLCJleHBvcnRzIiwidmFsdWUiLCJEeW5hbWljRmllbGQiLCJqcXVlcnlfMSIsInJlcXVpcmUiLCJwcm90b3R5cGUiLCJoaWRlU2hvd0Zvcm1GaWVsZHMiLCJodW1hbml0YXJpYW5TY29wZUhpZGVWb2NhYnVsYXJ5VXJpIiwiY291bnRyeUJ1ZGdldEhpZGVDb2RlRmllbGQiLCJhaWRUeXBlVm9jYWJ1bGFyeUhpZGVGaWVsZCIsInNlY3RvclZvY2FidWxhcnlIaWRlRmllbGQiLCJwb2xpY3lWb2NhYnVsYXJ5SGlkZUZpZWxkIiwicmVjaXBpZW50Vm9jYWJ1bGFyeUhpZGVGaWVsZCIsInRhZ1ZvY2FidWxhcnlIaWRlRmllbGQiLCJ0cmFuc2FjdGlvbkFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkIiwiaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkVXJpIiwiX3RoaXMiLCJodW1hbml0YXJpYW5TY29wZVZvY2FidWxhcnkiLCJsZW5ndGgiLCJlYWNoIiwiaW5kZXgiLCJzY29wZSIsIl9hIiwidmFsIiwiaGlkZUh1bWFuaXRhcmlhblNjb3BlRmllbGQiLCJ0b1N0cmluZyIsIm9uIiwiZSIsInBhcmFtcyIsImRhdGEiLCJpZCIsInRhcmdldCIsImNsb3Nlc3QiLCJmaW5kIiwic2hvdyIsInJlbW92ZUF0dHIiLCJ0cmlnZ2VyIiwiaGlkZSIsImF0dHIiLCJyZWZlcmVuY2VWb2NhYnVsYXJ5IiwiaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkIiwicmVmZXJlbmNlVXJpIiwiY291bnRyeUJ1ZGdldFZvY2FidWxhcnkiLCJoaWRlQ291bnRyeUJ1ZGdldEZpZWxkIiwiY291bnRyeUJ1ZGdldENvZGVJbnB1dCIsImNvdW50cnlCdWRnZXRDb2RlU2VsZWN0IiwiYWlkdHlwZV92b2NhYnVsYXJ5IiwiaXRlbSIsImhpZGVBaWRUeXBlU2VsZWN0RmllbGQiLCJoaWRlVHJhbnNhY3Rpb25BaWRUeXBlU2VsZWN0RmllbGQiLCJkZWZhdWx0X2FpZF90eXBlIiwiZWFybWFya2luZ19jYXRlZ29yeSIsImVhcm1hcmtpbmdfbW9kYWxpdHkiLCJjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXMiLCJjYXNlMSIsImNhc2UyIiwiY2FzZTMiLCJjYXNlNCIsImFpZF90eXBlIiwicG9saWN5bWFrZXJfdm9jYWJ1bGFyeSIsInBvbGljeV9tYXJrZXIiLCJoaWRlUG9saWN5TWFrZXJGaWVsZCIsImNhc2UxX3Nob3ciLCJjYXNlMl9zaG93Iiwic2VjdG9yX3ZvY2FidWxhcnkiLCJzZWN0b3IiLCJoaWRlU2VjdG9yRmllbGQiLCJjYXNlN19zaG93IiwiY2FzZThfc2hvdyIsImNhc2U5OF85OV9zaG93IiwiZGVmYXVsdF9zaG93IiwiY2FzZTciLCJjYXNlOCIsImNhc2U5OF85OSIsImRlZmF1bHRfaGlkZSIsInJlZ2lvbl92b2NhYnVsYXJ5IiwicmVnaW9uX3ZvY2FiIiwiaGlkZVJlY2lwaWVudFJlZ2lvbkZpZWxkIiwiY2FzZTk5X3Nob3ciLCJjYXNlOTkiLCJ1cGRhdGVBY3Rpdml0eUlkZW50aWZpZXIiLCJhY3Rpdml0eV9pZGVudGlmaWVyIiwiY29uY2F0IiwidGFnX3ZvY2FidWxhcnkiLCJ0YWciLCJoaWRlVGFnRmllbGQiLCJjYXNlM19zaG93IiwiYXhpb3NfMSIsIkR5bmFtaWNGaWVsZF8xIiwiZHluYW1pY0ZpZWxkIiwiRm9ybUJ1aWxkZXIiLCJhZGRGb3JtIiwiZXYiLCJwcmV2ZW50RGVmYXVsdCIsImNvbnRhaW5lciIsImNvdW50IiwicGFyc2VJbnQiLCJwYXJlbnQiLCJwYXJlbnRfY291bnQiLCJwYXJlbnRzIiwid3JhcHBlcl9wYXJlbnRfY291bnQiLCJwcm90byIsInJlcGxhY2UiLCJwcmV2IiwiYXBwZW5kIiwiY2hpbGRyZW4iLCJsYXN0Iiwic2VsZWN0MiIsInBsYWNlaG9sZGVyIiwiYWxsb3dDbGVhciIsIndyYXBBbGwiLCJhZGRQYXJlbnRGb3JtIiwiYWRkV3JhcHBlck9uQWRkIiwiZGVsZXRlRm9ybSIsImNvbGxlY3Rpb25MZW5ndGgiLCJ0ZyIsIm5leHQiLCJyZW1vdmUiLCJkZWxldGVQYXJlbnRGb3JtIiwiYWRkV3JhcHBlciIsImZvcm1GaWVsZCIsInRleHRBcmVhSGVpZ2h0IiwiaGVpZ2h0Iiwic2Nyb2xsSGVpZ2h0IiwiY3NzIiwiYWRkVG9Db2xsZWN0aW9uIiwiZXZlbnQiLCJoYXNDbGFzcyIsInN0b3BQcm9wYWdhdGlvbiIsImRlbGV0ZUNvbGxlY3Rpb24iLCJkZWxldGVDb25maXJtYXRpb24iLCJjYW5jZWxQb3B1cCIsImRlbGV0ZUNvbmZpcm0iLCJkZWxldGVJbmRleCIsImNoaWxkT3JQYXJlbnQiLCJmYWRlSW4iLCJmYWRlT3V0IiwiZmlsZVBhdGgiLCJ1cmwiLCJnZXQiLCJ0aGVuIiwicmVzcG9uc2UiLCJzdWNjZXNzIiwiZm9ybWF0IiwibWltZXR5cGUiLCJtZXNzYWdlIiwiY29uc29sZSIsImxvZyIsImZvcm1CdWlsZGVyIiwidGV4dEFyZWFUYXJnZXQiLCJzZWxlY3Rfc2VhcmNoIiwiZG9jdW1lbnQiLCJxdWVyeVNlbGVjdG9yIiwiZm9jdXMiLCJ1cGRhdGVSZWdpc3RyYXRpb25BZ2VuY3kiLCJjb3VudHJ5IiwiYWpheCIsImN1cnJlbnRfdmFsIiwiZW1wdHkiLCJPcHRpb24iLCJpZGVudGlmaWVyIiwic3ViZWxlbWVudCIsInF1ZXJ5U2VsZWN0b3JBbGwiLCJpIiwidGl0bGUiLCJlcnJvckNvbnRhaW5lciIsImNoaWxkQ291bnQiLCJjaGlsZEVsZW1lbnRDb3VudCIsImNsYXNzTGlzdCIsImFkZCIsInJlYWRPbmx5U2VsZWN0cyIsInNlbGVjdCIsInNlbGVjdEVsZW1lbnRQYXJlbnRXcmFwcGVyIiwibmV4dFNpYmxpbmciLCJzZWxlY3RFbGVtZW50UGFyZW50IiwiZmlyc3RDaGlsZCIsInNlbGVjdEVsZW1lbnQiLCJzdHlsZSIsImN1cnNvciJdLCJzb3VyY2VSb290IjoiIn0=
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

    (0, jquery_1["default"])('body').on('change', 'input[id*="[url]"]', function () {
      var _this = this;

      var _a;

      console.log('removing');
      var filePath = ((_a = (0, jquery_1["default"])(this).val()) !== null && _a !== void 0 ? _a : '').toString();
      var url = "/mimetype?url=".concat(filePath, "&type=url");
      (0, jquery_1["default"])(this).closest('.form-field').find('.text-danger').remove();

      if (filePath !== '') {
        axios_1["default"].get(url).then(function (response) {
          if (response.data.success) {
            var format = response.data.data.mimetype;
            (0, jquery_1["default"])(_this).closest('.form-field-group').find('select[id*="[format]"]').val(format).trigger('change');
          } else {
            (0, jquery_1["default"])(_this).closest('.form-field').find('.text-danger').remove();
            (0, jquery_1["default"])(_this).closest('.form-field').append("<div class='text-danger error'>" + response.data.message + "</div>");
            (0, jquery_1["default"])(_this).closest('.form-field-group').find('select[id*="[format]"]').val('').trigger('change');
          }
        });
        (0, jquery_1["default"])(this).closest('.form-field-group').find('input[id*="[document]"]').val('').trigger('change');
      }
    });
    (0, jquery_1["default"])('body').on('change', 'input[id*="[document]"]', function () {
      var _this = this;

      var _a;

      console.log('document');
      var filePath = ((_a = (0, jquery_1["default"])(this).val()) !== null && _a !== void 0 ? _a : '').toString();
      var url = "/mimetype?url=".concat(filePath, "&&type=document");
      (0, jquery_1["default"])(this).closest('.form-field').find('.text-danger').remove();

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
      }

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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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LGVBQWUsQ0FBQ1AsQ0FBRCxDQUE1QjtJQUNBLElBQUlTLDBCQUEwQixHQUFHRCxNQUFNLENBQUNFLFdBQXhDO0lBQ0EsSUFBSUMsbUJBQW1CLEdBQUdGLDBCQUEwQixLQUFLLElBQS9CLElBQXVDQSwwQkFBMEIsS0FBSyxLQUFLLENBQTNFLEdBQStFLEtBQUssQ0FBcEYsR0FBd0ZBLDBCQUEwQixDQUFDRyxVQUE3STtJQUNBLElBQUlDLGFBQWEsR0FBR0YsbUJBQW1CLEtBQUssSUFBeEIsSUFBZ0NBLG1CQUFtQixLQUFLLEtBQUssQ0FBN0QsR0FBaUUsS0FBSyxDQUF0RSxHQUEwRUEsbUJBQW1CLENBQUNDLFVBQWxIOztJQUNBLElBQUlDLGFBQUosRUFBbUI7TUFDZkEsYUFBYSxDQUFDQyxLQUFkLENBQW9CQyxNQUFwQixHQUE2QixhQUE3QjtJQUNIO0VBQ0o7QUFDSixDQXJGRCIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3Jlc291cmNlcy9hc3NldHMvanMvc2NyaXB0cy9EeW5hbWljRmllbGQudHMiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9qcy9zY3JpcHRzL2Zvcm1idWlsZGVyLnRzIl0sInNvdXJjZXNDb250ZW50IjpbIlwidXNlIHN0cmljdFwiO1xudmFyIF9faW1wb3J0RGVmYXVsdCA9ICh0aGlzICYmIHRoaXMuX19pbXBvcnREZWZhdWx0KSB8fCBmdW5jdGlvbiAobW9kKSB7XG4gICAgcmV0dXJuIChtb2QgJiYgbW9kLl9fZXNNb2R1bGUpID8gbW9kIDogeyBcImRlZmF1bHRcIjogbW9kIH07XG59O1xuT2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFwiX19lc01vZHVsZVwiLCB7IHZhbHVlOiB0cnVlIH0pO1xuZXhwb3J0cy5EeW5hbWljRmllbGQgPSB2b2lkIDA7XG52YXIganF1ZXJ5XzEgPSBfX2ltcG9ydERlZmF1bHQocmVxdWlyZShcImpxdWVyeVwiKSk7XG5yZXF1aXJlKFwic2VsZWN0MlwiKTtcbnZhciBEeW5hbWljRmllbGQgPSAvKiogQGNsYXNzICovIChmdW5jdGlvbiAoKSB7XG4gICAgZnVuY3Rpb24gRHluYW1pY0ZpZWxkKCkge1xuICAgIH1cbiAgICAvKipcbiAgICAgKiBIaWRlIGFuZCBTaG93IGRpZmZlcmVudCBmb3JtIGZpZWxkcyBiYXNlZCBvbiB2b2NhYnVsYXJ5IGFuZCBvdGhlciB0eXBlc1xuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaGlkZVNob3dGb3JtRmllbGRzID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB0aGlzLmh1bWFuaXRhcmlhblNjb3BlSGlkZVZvY2FidWxhcnlVcmkoKTtcbiAgICAgICAgdGhpcy5jb3VudHJ5QnVkZ2V0SGlkZUNvZGVGaWVsZCgpO1xuICAgICAgICB0aGlzLmFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIHRoaXMuc2VjdG9yVm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICB0aGlzLnBvbGljeVZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgdGhpcy5yZWNpcGllbnRWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIHRoaXMuc2VjdG9yVm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICB0aGlzLnRhZ1ZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgdGhpcy50cmFuc2FjdGlvbkFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIHRoaXMuaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkVXJpKCk7XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBIdW1hbml0YXJpYW4gU2NvcGUgRm9ybSBQYWdlXG4gICAgICpcbiAgICAgKiBATG9naWMgaGlkZSB2b2NhYnVsYXJ5LXVyaSBmaWVsZCBiYXNlZCBvbiAnQHZvY2FidWxhcnknIGZpZWxkIHZhbHVlXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5odW1hbml0YXJpYW5TY29wZUhpZGVWb2NhYnVsYXJ5VXJpID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuICAgICAgICB2YXIgaHVtYW5pdGFyaWFuU2NvcGVWb2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3RbaWRePVwiaHVtYW5pdGFyaWFuX3Njb3BlXCJdW2lkKj1cIlt2b2NhYnVsYXJ5XVwiXScpO1xuICAgICAgICBpZiAoaHVtYW5pdGFyaWFuU2NvcGVWb2NhYnVsYXJ5Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIC8vIGhpZGUgZmllbGRzIG9uIHBhZ2UgbG9hZFxuICAgICAgICAgICAganF1ZXJ5XzEuZGVmYXVsdC5lYWNoKGh1bWFuaXRhcmlhblNjb3BlVm9jYWJ1bGFyeSwgZnVuY3Rpb24gKGluZGV4LCBzY29wZSkge1xuICAgICAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgICAgICB2YXIgdmFsID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHNjb3BlKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJyc7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZUh1bWFuaXRhcmlhblNjb3BlRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHNjb3BlKSwgdmFsLnRvU3RyaW5nKCkpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAvLyBoaWRlL3Nob3cgZmllbGRzIG9uIHZhbHVlIGNoYW5nZVxuICAgICAgICAgICAgaHVtYW5pdGFyaWFuU2NvcGVWb2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOnNlbGVjdCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIHZhbCA9IGUucGFyYW1zLmRhdGEuaWQ7XG4gICAgICAgICAgICAgICAgdmFyIGluZGV4ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZUh1bWFuaXRhcmlhblNjb3BlRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGluZGV4KSwgdmFsKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgLy8gaGlkZS9zaG93IGZpZWxkcyBvbiB2YWx1ZSBjbGVhclxuICAgICAgICAgICAgaHVtYW5pdGFyaWFuU2NvcGVWb2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgaW5kZXggPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlSHVtYW5pdGFyaWFuU2NvcGVGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaW5kZXgpLCAnJyk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLy8gaGlkZSBjb3VudHJ5IGJ1ZGdldCBiYXNlZCBvbiB2b2NhYnVsYXJ5XG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5oaWRlSHVtYW5pdGFyaWFuU2NvcGVGaWVsZCA9IGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcbiAgICAgICAgdmFyIGh1bWFuaXRhcmlhblNjb3BlSGlkZVZvY2FidWxhcnlVcmkgPSAnaW5wdXRbaWRePVwiaHVtYW5pdGFyaWFuX3Njb3BlXCJdW2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0nO1xuICAgICAgICBpZiAodmFsdWUgPT09ICc5OScpIHtcbiAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAuZmluZChodW1hbml0YXJpYW5TY29wZUhpZGVWb2NhYnVsYXJ5VXJpKVxuICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgfVxuICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAuZmluZChodW1hbml0YXJpYW5TY29wZUhpZGVWb2NhYnVsYXJ5VXJpKVxuICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICogSHVtYW5pdGFyaWFuIFNjb3BlIEZvcm0gUGFnZVxuICAgKlxuICAgKiBATG9naWMgaGlkZSB2b2NhYnVsYXJ5LXVyaSBmaWVsZCBiYXNlZCBvbiAnQHZvY2FidWxhcnknIGZpZWxkIHZhbHVlXG4gICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkVXJpID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuICAgICAgICB2YXIgcmVmZXJlbmNlVm9jYWJ1bGFyeSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnc2VsZWN0W2lkXj1cInJlZmVyZW5jZVwiXVtpZCo9XCJbdm9jYWJ1bGFyeV1cIl0nKTtcbiAgICAgICAgaWYgKHJlZmVyZW5jZVZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAgLy8gaGlkZSBmaWVsZHMgb24gcGFnZSBsb2FkXG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2gocmVmZXJlbmNlVm9jYWJ1bGFyeSwgZnVuY3Rpb24gKGluZGV4LCBzY29wZSkge1xuICAgICAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgICAgICB2YXIgdmFsID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHNjb3BlKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJyc7XG4gICAgICAgICAgICAgICAgX3RoaXMuaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShzY29wZSksIHZhbC50b1N0cmluZygpKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgLy8gaGlkZS9zaG93IGZpZWxkcyBvbiB2YWx1ZSBjaGFuZ2VcbiAgICAgICAgICAgIHJlZmVyZW5jZVZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgdmFsID0gZS5wYXJhbXMuZGF0YS5pZDtcbiAgICAgICAgICAgICAgICB2YXIgaW5kZXggPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5pbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGluZGV4KSwgdmFsKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgLy8gaGlkZS9zaG93IGZpZWxkcyBvbiB2YWx1ZSBjbGVhclxuICAgICAgICAgICAgcmVmZXJlbmNlVm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIGluZGV4ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShpbmRleCksICcnKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvLyBoaWRlIGNvdW50cnkgYnVkZ2V0IGJhc2VkIG9uIHZvY2FidWxhcnlcbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmluZGljYXRvclJlZmVyZW5jZUhpZGVGaWVsZCA9IGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcbiAgICAgICAgdmFyIHJlZmVyZW5jZVVyaSA9ICdpbnB1dFtpZF49XCJyZWZlcmVuY2VcIl1baWQqPVwiW2luZGljYXRvcl91cmldXCJdJztcbiAgICAgICAgaWYgKHZhbHVlID09PSAnOTknKSB7XG4gICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgLmZpbmQocmVmZXJlbmNlVXJpKVxuICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgfVxuICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAuZmluZChyZWZlcmVuY2VVcmkpXG4gICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIENvdW50cnkgQnVkZ2V0IEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIHNob3cvaGlkZSAnY29kZScgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuY291bnRyeUJ1ZGdldEhpZGVDb2RlRmllbGQgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgIHZhciBfYTtcbiAgICAgICAgdmFyIGNvdW50cnlCdWRnZXRWb2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3QjY291bnRyeV9idWRnZXRfdm9jYWJ1bGFyeScpO1xuICAgICAgICBpZiAoY291bnRyeUJ1ZGdldFZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAgLy8gaGlkZS9zaG93IG9uIHBhZ2UgbG9hZFxuICAgICAgICAgICAgdmFyIHZhbCA9IChfYSA9IGNvdW50cnlCdWRnZXRWb2NhYnVsYXJ5LnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnMSc7XG4gICAgICAgICAgICB0aGlzLmhpZGVDb3VudHJ5QnVkZ2V0RmllbGQodmFsLnRvU3RyaW5nKCkpO1xuICAgICAgICAgICAgLy8gaGlkZS9zaG93IG9uIHZhbHVlIGNoYW5nZVxuICAgICAgICAgICAgY291bnRyeUJ1ZGdldFZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgdmFsID0gZS5wYXJhbXMuZGF0YS5pZDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlQ291bnRyeUJ1ZGdldEZpZWxkKHZhbCk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIC8vaGlkZS9zaG93IGJhc2VkIG9uIHZhbHVlIGNsZWFyZWRcbiAgICAgICAgICAgIGNvdW50cnlCdWRnZXRWb2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVDb3VudHJ5QnVkZ2V0RmllbGQoJycpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEhpZGUgQ291bnRyeSBCdWRnZXQgRmllbGRzXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5oaWRlQ291bnRyeUJ1ZGdldEZpZWxkID0gZnVuY3Rpb24gKHZhbHVlKSB7XG4gICAgICAgIHZhciBjb3VudHJ5QnVkZ2V0Q29kZUlucHV0ID0gJ2lucHV0W2lkXj1cImJ1ZGdldF9pdGVtXCJdW2lkKj1cIltjb2RlX3RleHRdXCJdJywgY291bnRyeUJ1ZGdldENvZGVTZWxlY3QgPSAnc2VsZWN0W2lkXj1cImJ1ZGdldF9pdGVtXCJdW2lkKj1cIltjb2RlXVwiXSc7XG4gICAgICAgIGlmICh2YWx1ZSA9PT0gJzEnKSB7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoY291bnRyeUJ1ZGdldENvZGVTZWxlY3QpXG4gICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJykuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShjb3VudHJ5QnVkZ2V0Q29kZUlucHV0KS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJykuc2hvdygpO1xuICAgICAgICB9XG4gICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGNvdW50cnlCdWRnZXRDb2RlU2VsZWN0KS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJykuc2hvdygpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGNvdW50cnlCdWRnZXRDb2RlSW5wdXQpXG4gICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEFpZFR5cGUgRm9ybSBQYWdlXG4gICAgICpcbiAgICAgKiBATG9naWMgaGlkZSB2b2NhYnVsYXJ5LXVyaSBhbmQgY29kZXMgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuYWlkVHlwZVZvY2FidWxhcnlIaWRlRmllbGQgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgIHZhciBhaWR0eXBlX3ZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdFtpZCo9XCJkZWZhdWx0X2FpZF90eXBlX3ZvY2FidWxhcnlcIl0nKTtcbiAgICAgICAgaWYgKGFpZHR5cGVfdm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2goYWlkdHlwZV92b2NhYnVsYXJ5LCBmdW5jdGlvbiAoaW5kZXgsIGl0ZW0pIHtcbiAgICAgICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSAoX2EgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaXRlbSkudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcxJztcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlQWlkVHlwZVNlbGVjdEZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShpdGVtKSwgZGF0YS50b1N0cmluZygpKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgYWlkdHlwZV92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOnNlbGVjdCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSBlLnBhcmFtcy5kYXRhLmlkO1xuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlQWlkVHlwZVNlbGVjdEZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCBkYXRhKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgYWlkdHlwZV92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZUFpZFR5cGVTZWxlY3RGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgJycpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEFpZFR5cGUgRm9ybSBQYWdlXG4gICAgICpcbiAgICAgKiBATG9naWMgaGlkZSB2b2NhYnVsYXJ5LXVyaSBhbmQgY29kZXMgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUudHJhbnNhY3Rpb25BaWRUeXBlVm9jYWJ1bGFyeUhpZGVGaWVsZCA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgdmFyIGFpZHR5cGVfdm9jYWJ1bGFyeSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnc2VsZWN0W2lkKj1cImFpZF90eXBlX3ZvY2FidWxhcnlcIl0nKTtcbiAgICAgICAgaWYgKGFpZHR5cGVfdm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2goYWlkdHlwZV92b2NhYnVsYXJ5LCBmdW5jdGlvbiAoaW5kZXgsIGl0ZW0pIHtcbiAgICAgICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSAoX2EgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaXRlbSkudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcxJztcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlVHJhbnNhY3Rpb25BaWRUeXBlU2VsZWN0RmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGl0ZW0pLCBkYXRhLnRvU3RyaW5nKCkpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICBhaWR0eXBlX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IGUucGFyYW1zLmRhdGEuaWQ7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVUcmFuc2FjdGlvbkFpZFR5cGVTZWxlY3RGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgZGF0YSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIGFpZHR5cGVfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVUcmFuc2FjdGlvbkFpZFR5cGVTZWxlY3RGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgJycpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEhpZGUgQWlkIFR5cGUgU2VsZWN0IEZpZWxkc1xuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaGlkZUFpZFR5cGVTZWxlY3RGaWVsZCA9IGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcbiAgICAgICAgdmFyIGRlZmF1bHRfYWlkX3R5cGUgPSAnc2VsZWN0W2lkKj1cIltkZWZhdWx0X2FpZF90eXBlXVwiXScsIGVhcm1hcmtpbmdfY2F0ZWdvcnkgPSAnc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX2NhdGVnb3J5XVwiXScsIGVhcm1hcmtpbmdfbW9kYWxpdHkgPSAnc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX21vZGFsaXR5XVwiXScsIGNhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllcyA9ICdzZWxlY3RbaWQqPVwiW2Nhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllc11cIl0nLCBjYXNlMSA9ICdzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfY2F0ZWdvcnldXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19tb2RhbGl0eV1cIl0sc2VsZWN0W2lkKj1cIltjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXNdXCJdJywgY2FzZTIgPSAnc2VsZWN0W2lkKj1cIltkZWZhdWx0X2FpZF90eXBlXVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfbW9kYWxpdHldXCJdLHNlbGVjdFtpZCo9XCJbY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzXVwiXScsIGNhc2UzID0gJ3NlbGVjdFtpZCo9XCJbZGVmYXVsdF9haWRfdHlwZV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX2NhdGVnb3J5XVwiXSxzZWxlY3RbaWQqPVwiW2Nhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllc11cIl0nLCBjYXNlNCA9ICdzZWxlY3RbaWQqPVwiW2RlZmF1bHRfYWlkX3R5cGVdXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19jYXRlZ29yeV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX21vZGFsaXR5XVwiXSc7XG4gICAgICAgIHN3aXRjaCAodmFsdWUpIHtcbiAgICAgICAgICAgIGNhc2UgJzInOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGVhcm1hcmtpbmdfY2F0ZWdvcnkpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICczJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChlYXJtYXJraW5nX21vZGFsaXR5KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMylcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnNCc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlNClcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgZGVmYXVsdDpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChkZWZhdWx0X2FpZF90eXBlKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBIaWRlIFRyYW5zYWN0aW9uIEFpZCBUeXBlIFNlbGVjdCBGaWVsZHNcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmhpZGVUcmFuc2FjdGlvbkFpZFR5cGVTZWxlY3RGaWVsZCA9IGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcbiAgICAgICAgdmFyIGFpZF90eXBlID0gJ3NlbGVjdFtpZCo9XCJbYWlkX3R5cGVfY29kZV1cIl0nLCBlYXJtYXJraW5nX2NhdGVnb3J5ID0gJ3NlbGVjdFtpZCo9XCJbZWFybWFya2luZ19jYXRlZ29yeV1cIl0nLCBlYXJtYXJraW5nX21vZGFsaXR5ID0gJ3NlbGVjdFtpZCo9XCJbZWFybWFya2luZ19tb2RhbGl0eV1cIl0nLCBjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXMgPSAnc2VsZWN0W2lkKj1cIltjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXNdXCJdJywgY2FzZTEgPSAnc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX2NhdGVnb3J5XVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfbW9kYWxpdHldXCJdLHNlbGVjdFtpZCo9XCJbY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzXVwiXScsIGNhc2UyID0gJ3NlbGVjdFtpZCo9XCJbYWlkX3R5cGVfY29kZV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX21vZGFsaXR5XVwiXSxzZWxlY3RbaWQqPVwiW2Nhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllc11cIl0nLCBjYXNlMyA9ICdzZWxlY3RbaWQqPVwiW2FpZF90eXBlX2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19jYXRlZ29yeV1cIl0sc2VsZWN0W2lkKj1cIltjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXNdXCJdJywgY2FzZTQgPSAnc2VsZWN0W2lkKj1cIlthaWRfdHlwZV9jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfY2F0ZWdvcnldXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19tb2RhbGl0eV1cIl0nO1xuICAgICAgICBzd2l0Y2ggKHZhbHVlKSB7XG4gICAgICAgICAgICBjYXNlICcyJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChlYXJtYXJraW5nX2NhdGVnb3J5KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMilcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnMyc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoZWFybWFya2luZ19tb2RhbGl0eSlcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTMpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzQnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllcylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTQpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGRlZmF1bHQ6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoYWlkX3R5cGUpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIFBvbGljeSBNYXJrZXIgRm9ybSBQYWdlXG4gICAgICpcbiAgICAgKiBATG9naWMgaGlkZSB2b2NhYnVsYXJ5LXVyaSBhbmQgY29kZXMgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUucG9saWN5Vm9jYWJ1bGFyeUhpZGVGaWVsZCA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgdmFyIHBvbGljeW1ha2VyX3ZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdFtpZCo9XCJwb2xpY3lfbWFya2VyX3ZvY2FidWxhcnlcIl0nKTtcbiAgICAgICAgaWYgKHBvbGljeW1ha2VyX3ZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAganF1ZXJ5XzEuZGVmYXVsdC5lYWNoKHBvbGljeW1ha2VyX3ZvY2FidWxhcnksIGZ1bmN0aW9uIChpbmRleCwgcG9saWN5X21hcmtlcikge1xuICAgICAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShwb2xpY3lfbWFya2VyKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJzEnO1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVQb2xpY3lNYWtlckZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShwb2xpY3lfbWFya2VyKSwgZGF0YS50b1N0cmluZygpKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgcG9saWN5bWFrZXJfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpzZWxlY3QnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gZS5wYXJhbXMuZGF0YS5pZDtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVBvbGljeU1ha2VyRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksIGRhdGEpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICBwb2xpY3ltYWtlcl92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVBvbGljeU1ha2VyRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksICc5OScpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEhpZGVzIFBvbGljeSBNYXJrZXIgRm9ybSBGaWVsZHNcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmhpZGVQb2xpY3lNYWtlckZpZWxkID0gZnVuY3Rpb24gKGluZGV4LCB2YWx1ZSkge1xuICAgICAgICB2YXIgY2FzZTFfc2hvdyA9ICdzZWxlY3RbaWQqPVwiW3BvbGljeV9tYXJrZXJdXCJdJywgY2FzZTJfc2hvdyA9ICdpbnB1dFtpZCo9XCJbcG9saWN5X21hcmtlcl90ZXh0XVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdJywgY2FzZTEgPSAnaW5wdXRbaWQqPVwiW3BvbGljeV9tYXJrZXJfdGV4dF1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXScsIGNhc2UyID0gJ3NlbGVjdFtpZCo9XCJbcG9saWN5X21hcmtlcl1cIl0nO1xuICAgICAgICBzd2l0Y2ggKHZhbHVlKSB7XG4gICAgICAgICAgICBjYXNlICcxJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMV9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnOTknOlxuICAgICAgICAgICAgZGVmYXVsdDpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMl9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMilcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBTZWN0b3IgRm9ybSBQYWdlXG4gICAgICpcbiAgICAgKiBATG9naWMgaGlkZSB2b2NhYnVsYXJ5LXVyaSBhbmQgY29kZXMgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuc2VjdG9yVm9jYWJ1bGFyeUhpZGVGaWVsZCA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgdmFyIHNlY3Rvcl92b2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3RbaWQqPVwic2VjdG9yX3ZvY2FidWxhcnlcIl0nKTtcbiAgICAgICAgaWYgKHNlY3Rvcl92b2NhYnVsYXJ5Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuZWFjaChzZWN0b3Jfdm9jYWJ1bGFyeSwgZnVuY3Rpb24gKGluZGV4LCBzZWN0b3IpIHtcbiAgICAgICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSAoX2EgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoc2VjdG9yKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJzEnO1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVTZWN0b3JGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoc2VjdG9yKSwgZGF0YS50b1N0cmluZygpKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgc2VjdG9yX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IGUucGFyYW1zLmRhdGEuaWQ7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVTZWN0b3JGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgZGF0YSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIHNlY3Rvcl92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVNlY3RvckZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCAnJyk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogSGlkZSBTZWN0b3IgRm9ybSBmaWVsZHNcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmhpZGVTZWN0b3JGaWVsZCA9IGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcbiAgICAgICAgdmFyIGNhc2UxX3Nob3cgPSAnc2VsZWN0W2lkKj1cIltjb2RlXVwiXScsIGNhc2UyX3Nob3cgPSAnc2VsZWN0W2lkKj1cIltjYXRlZ29yeV9jb2RlXVwiXScsIGNhc2U3X3Nob3cgPSAnc2VsZWN0W2lkKj1cIltzZGdfZ29hbF1cIl0nLCBjYXNlOF9zaG93ID0gJ3NlbGVjdFtpZCo9XCJbc2RnX3RhcmdldF1cIl0nLCBjYXNlOThfOTlfc2hvdyA9ICdpbnB1dFtpZCo9XCJbdGV4dF1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXScsIGRlZmF1bHRfc2hvdyA9ICdpbnB1dFtpZCo9XCJbdGV4dF1cIl0nLCBjYXNlMSA9ICdzZWxlY3RbaWQqPVwiW2NhdGVnb3J5X2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX2dvYWxdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX3RhcmdldF1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSxpbnB1dFtpZCo9XCJbdGV4dF1cIl0nLCBjYXNlMiA9ICdpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdLHNlbGVjdFtpZCo9XCJbc2RnX2dvYWxdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX3RhcmdldF1cIl0sc2VsZWN0W2lkKj1cIltjb2RlXVwiXSxpbnB1dFtpZCo9XCJbdGV4dF1cIl0nLCBjYXNlNyA9ICdpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdLHNlbGVjdFtpZCo9XCJbY2F0ZWdvcnlfY29kZV1cIl0sc2VsZWN0W2lkKj1cIltzZGdfdGFyZ2V0XVwiXSxzZWxlY3RbaWQqPVwiW2NvZGVdXCJdLGlucHV0W2lkKj1cIlt0ZXh0XVwiXScsIGNhc2U4ID0gJ2lucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0sc2VsZWN0W2lkKj1cIltjYXRlZ29yeV9jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ19nb2FsXVwiXSxzZWxlY3RbaWQqPVwiW2NvZGVdXCJdLGlucHV0W2lkKj1cIlt0ZXh0XVwiXScsIGNhc2U5OF85OSA9ICdzZWxlY3RbaWQqPVwiW2NhdGVnb3J5X2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX2dvYWxdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX3RhcmdldF1cIl0sc2VsZWN0W2lkKj1cIltjb2RlXVwiXScsIGRlZmF1bHRfaGlkZSA9ICdzZWxlY3RbaWQqPVwiW2NhdGVnb3J5X2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX2dvYWxdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX3RhcmdldF1cIl0sc2VsZWN0W2lkKj1cIltjb2RlXVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdJztcbiAgICAgICAgc3dpdGNoICh2YWx1ZSkge1xuICAgICAgICAgICAgY2FzZSAnMSc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTFfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTEpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzInOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICc3JzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlN19zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlNylcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnOCc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZThfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTgpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzk4JzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOThfOTlfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTk4Xzk5KVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICc5OSc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTk4Xzk5X3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U5OF85OSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgZGVmYXVsdDpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChkZWZhdWx0X3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGRlZmF1bHRfaGlkZSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiAgUmVjaXBpZW50IFZvY2FidWxhcnkgRm9ybSBQYWdlXG4gICAgICpcbiAgICAgKiBATG9naWMgaGlkZSB2b2NhYnVsYXJ5LXVyaSBhbmQgY29kZXMgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUucmVjaXBpZW50Vm9jYWJ1bGFyeUhpZGVGaWVsZCA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgdmFyIHJlZ2lvbl92b2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3RbaWQqPVwicmVnaW9uX3ZvY2FidWxhcnlcIl0nKTtcbiAgICAgICAgaWYgKHJlZ2lvbl92b2NhYnVsYXJ5Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuZWFjaChyZWdpb25fdm9jYWJ1bGFyeSwgZnVuY3Rpb24gKGluZGV4LCByZWdpb25fdm9jYWIpIHtcbiAgICAgICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSAoX2EgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkocmVnaW9uX3ZvY2FiKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJzEnO1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVSZWNpcGllbnRSZWdpb25GaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkocmVnaW9uX3ZvY2FiKSwgZGF0YS50b1N0cmluZygpKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgcmVnaW9uX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IGUucGFyYW1zLmRhdGEuaWQ7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVSZWNpcGllbnRSZWdpb25GaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgZGF0YSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIHJlZ2lvbl92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVJlY2lwaWVudFJlZ2lvbkZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCAnJyk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogSGlkZXMgUmVjaXBpZW50IFJlZ2lvbiBGb3JtIEZpZWxkc1xuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaGlkZVJlY2lwaWVudFJlZ2lvbkZpZWxkID0gZnVuY3Rpb24gKGluZGV4LCB2YWx1ZSkge1xuICAgICAgICB2YXIgY2FzZTFfc2hvdyA9ICdzZWxlY3RbaWQqPVwiW3JlZ2lvbl9jb2RlXVwiXScsIGNhc2UyX3Nob3cgPSAnaW5wdXRbaWQqPVwiW2N1c3RvbV9jb2RlXVwiXSwgaW5wdXRbaWQqPVwiW2NvZGVdXCJdJywgY2FzZTk5X3Nob3cgPSAnaW5wdXRbaWQqPVwiW2N1c3RvbV9jb2RlXVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdLCBpbnB1dFtpZCo9XCJbY29kZV1cIl0nLCBjYXNlMSA9ICdpbnB1dFtpZCo9XCJbY3VzdG9tX2NvZGVdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0saW5wdXRbaWQqPVwiW2NvZGVdXCJdJywgY2FzZTIgPSAnc2VsZWN0W2lkKj1cIltyZWdpb25fY29kZV1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXScsIGNhc2U5OSA9ICdzZWxlY3RbaWQqPVwiW3JlZ2lvbl9jb2RlXVwiXSc7XG4gICAgICAgIHN3aXRjaCAodmFsdWUpIHtcbiAgICAgICAgICAgIGNhc2UgJzEnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICcyJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMl9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMilcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnOTknOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U5OV9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOTkpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGRlZmF1bHQ6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTJfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTIpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogVXBkYXRlcyBBY3Rpdml0eSBpZGVudGlmaWVyXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS51cGRhdGVBY3Rpdml0eUlkZW50aWZpZXIgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBhY3Rpdml0eV9pZGVudGlmaWVyID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjYWN0aXZpdHlfaWRlbnRpZmllcicpO1xuICAgICAgICBpZiAoYWN0aXZpdHlfaWRlbnRpZmllci5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBhY3Rpdml0eV9pZGVudGlmaWVyLm9uKCdrZXl1cCcsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNpYXRpX2lkZW50aWZpZXJfdGV4dCcpLnZhbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5pZGVudGlmaWVyJykuYXR0cignYWN0aXZpdHlfaWRlbnRpZmllcicpICsgXCItXCIuY29uY2F0KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS52YWwoKSkpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIFRhZyBGb3JtIFBhZ2VcbiAgICAgKlxuICAgICAqIEBMb2dpYyBoaWRlIHZvY2FidWxhcnktdXJpIGFuZCBjb2RlcyBmaWVsZCBiYXNlZCBvbiAnQHZvY2FidWxhcnknIGZpZWxkIHZhbHVlXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS50YWdWb2NhYnVsYXJ5SGlkZUZpZWxkID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuICAgICAgICB2YXIgdGFnX3ZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdFtpZCo9XCJ0YWdfdm9jYWJ1bGFyeVwiXScpO1xuICAgICAgICBpZiAodGFnX3ZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAganF1ZXJ5XzEuZGVmYXVsdC5lYWNoKHRhZ192b2NhYnVsYXJ5LCBmdW5jdGlvbiAoaW5kZXgsIHRhZykge1xuICAgICAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YWcpLnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnMSc7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVRhZ0ZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YWcpLCBkYXRhLnRvU3RyaW5nKCkpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICB0YWdfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpzZWxlY3QnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gZS5wYXJhbXMuZGF0YS5pZDtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVRhZ0ZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCBkYXRhKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgdGFnX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6Y2xlYXInLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlVGFnRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksICcnKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBIaWRlIFRhZyBGb3JtIGZpZWxkc1xuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaGlkZVRhZ0ZpZWxkID0gZnVuY3Rpb24gKGluZGV4LCB2YWx1ZSkge1xuICAgICAgICB2YXIgY2FzZTFfc2hvdyA9ICdpbnB1dFtpZCo9XCJbdGFnX3RleHRdXCJdJywgY2FzZTJfc2hvdyA9ICdzZWxlY3RbaWQqPVwiW2dvYWxzX3RhZ19jb2RlXVwiXScsIGNhc2UzX3Nob3cgPSAnc2VsZWN0W2lkKj1cIlt0YXJnZXRzX3RhZ19jb2RlXVwiXScsIGNhc2U5OV9zaG93ID0gJ2lucHV0W2lkKj1cIlt0YWdfdGV4dF1cIl0sIGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0nLCBjYXNlMSA9ICdzZWxlY3RbaWQqPVwiW2dvYWxzX3RhZ19jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW3RhcmdldHNfdGFnX2NvZGVdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0nLCBjYXNlMiA9ICdpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdLHNlbGVjdFtpZCo9XCJbdGFyZ2V0c190YWdfY29kZV1cIl0sc2VsZWN0W2lkKj1cIlt0YXJnZXRzX3RhZ19jb2RlXVwiXSxpbnB1dFtpZCo9XCJbdGFnX3RleHRdXCJdJywgY2FzZTMgPSAnaW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSxzZWxlY3RbaWQqPVwiW2dvYWxzX3RhZ19jb2RlXVwiXSxpbnB1dFtpZCo9XCJbdGFnX3RleHRdXCJdJywgY2FzZTk5ID0gJ3NlbGVjdFtpZCo9XCJbZ29hbHNfdGFnX2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbdGFyZ2V0c190YWdfY29kZV1cIl0nO1xuICAgICAgICBzd2l0Y2ggKHZhbHVlKSB7XG4gICAgICAgICAgICBjYXNlICcxJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMV9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnMic6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTJfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTIpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzMnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UzX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UzKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICc5OSc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTk5X3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U5OSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgZGVmYXVsdDpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMV9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICByZXR1cm4gRHluYW1pY0ZpZWxkO1xufSgpKTtcbmV4cG9ydHMuRHluYW1pY0ZpZWxkID0gRHluYW1pY0ZpZWxkO1xuIiwiXCJ1c2Ugc3RyaWN0XCI7XG52YXIgX19pbXBvcnREZWZhdWx0ID0gKHRoaXMgJiYgdGhpcy5fX2ltcG9ydERlZmF1bHQpIHx8IGZ1bmN0aW9uIChtb2QpIHtcbiAgICByZXR1cm4gKG1vZCAmJiBtb2QuX19lc01vZHVsZSkgPyBtb2QgOiB7IFwiZGVmYXVsdFwiOiBtb2QgfTtcbn07XG5PYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgXCJfX2VzTW9kdWxlXCIsIHsgdmFsdWU6IHRydWUgfSk7XG52YXIgYXhpb3NfMSA9IF9faW1wb3J0RGVmYXVsdChyZXF1aXJlKFwiYXhpb3NcIikpO1xudmFyIGpxdWVyeV8xID0gX19pbXBvcnREZWZhdWx0KHJlcXVpcmUoXCJqcXVlcnlcIikpO1xucmVxdWlyZShcInNlbGVjdDJcIik7XG52YXIgRHluYW1pY0ZpZWxkXzEgPSByZXF1aXJlKFwiLi9EeW5hbWljRmllbGRcIik7XG52YXIgZHluYW1pY0ZpZWxkID0gbmV3IER5bmFtaWNGaWVsZF8xLkR5bmFtaWNGaWVsZCgpO1xudmFyIEZvcm1CdWlsZGVyID0gLyoqIEBjbGFzcyAqLyAoZnVuY3Rpb24gKCkge1xuICAgIGZ1bmN0aW9uIEZvcm1CdWlsZGVyKCkge1xuICAgIH1cbiAgICAvLyBhZGRzIG5ldyBjb2xsZWN0aW9uIG9mIHN1Yi1lbGVtZW50XG4gICAgRm9ybUJ1aWxkZXIucHJvdG90eXBlLmFkZEZvcm0gPSBmdW5jdGlvbiAoZXYpIHtcbiAgICAgICAgZXYucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgdmFyIHRhcmdldCA9IGV2LnRhcmdldDtcbiAgICAgICAgdmFyIGNvbnRhaW5lciA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2Zvcm1fdHlwZScpXG4gICAgICAgICAgICA/ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShcIi5jb2xsZWN0aW9uLWNvbnRhaW5lcltmb3JtX3R5cGUgPSdcIi5jb25jYXQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignZm9ybV90eXBlJyksIFwiJ11cIikpXG4gICAgICAgICAgICA6ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmNvbGxlY3Rpb24tY29udGFpbmVyJyk7XG4gICAgICAgIHZhciBjb3VudCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2NoaWxkX2NvdW50JylcbiAgICAgICAgICAgID8gcGFyc2VJbnQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignY2hpbGRfY291bnQnKSkgKyAxXG4gICAgICAgICAgICA6ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLnBhcmVudCgpLmZpbmQoJy5mb3JtLWNoaWxkLWJvZHknKS5sZW5ndGg7XG4gICAgICAgIHZhciBwYXJlbnRfY291bnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdwYXJlbnRfY291bnQnKVxuICAgICAgICAgICAgPyBwYXJzZUludCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdwYXJlbnRfY291bnQnKSlcbiAgICAgICAgICAgIDogKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucGFyZW50cygnLm11bHRpLWZvcm0nKS5pbmRleCgpIC0gMTtcbiAgICAgICAgdmFyIHdyYXBwZXJfcGFyZW50X2NvdW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignd3JhcHBlZF9wYXJlbnRfY291bnQnKVxuICAgICAgICAgICAgPyBwYXJzZUludCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCd3cmFwcGVkX3BhcmVudF9jb3VudCcpKVxuICAgICAgICAgICAgOiAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wYXJlbnRzKCcud3JhcHBlZC1jaGlsZC1ib2R5JykuaW5kZXgoKSAtIDE7XG4gICAgICAgIHZhciBwcm90byA9IGNvbnRhaW5lclxuICAgICAgICAgICAgLmRhdGEoJ3Byb3RvdHlwZScpXG4gICAgICAgICAgICAucmVwbGFjZSgvX19QQVJFTlRfTkFNRV9fL2csIHBhcmVudF9jb3VudCk7XG4gICAgICAgIGlmICgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdoYXNfY2hpbGRfY29sbGVjdGlvbicpKSB7XG4gICAgICAgICAgICBwcm90byA9IHByb3RvLnJlcGxhY2UoL19fV1JBUFBFUl9OQU1FX18vZywgY291bnQpO1xuICAgICAgICAgICAgcHJvdG8gPSBwcm90by5yZXBsYWNlKC9fX05BTUVfXy9nLCAwKTtcbiAgICAgICAgfVxuICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgIHByb3RvID0gcHJvdG8ucmVwbGFjZSgvX19OQU1FX18vZywgY291bnQpO1xuICAgICAgICAgICAgcHJvdG8gPSBwcm90by5yZXBsYWNlKC9fX1dSQVBQRVJfTkFNRV9fL2csIHdyYXBwZXJfcGFyZW50X2NvdW50KTtcbiAgICAgICAgfVxuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wcmV2KCkuYXBwZW5kKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShwcm90bykpO1xuICAgICAgICBpZiAoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignaGFzX2NoaWxkX2NvbGxlY3Rpb24nKSkge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldClcbiAgICAgICAgICAgICAgICAucHJldignLnN1YmVsZW1lbnQnKVxuICAgICAgICAgICAgICAgIC5jaGlsZHJlbignLndyYXBwZWQtY2hpbGQtYm9keScpXG4gICAgICAgICAgICAgICAgLmxhc3QoKVxuICAgICAgICAgICAgICAgIC5maW5kKCcuYWRkX3RvX2NvbGxlY3Rpb24nKVxuICAgICAgICAgICAgICAgIC5hdHRyKCd3cmFwcGVkX3BhcmVudF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXG4gICAgICAgICAgICAgICAgLnByZXYoJy5zdWJlbGVtZW50JylcbiAgICAgICAgICAgICAgICAuY2hpbGRyZW4oJy53cmFwcGVkLWNoaWxkLWJvZHknKVxuICAgICAgICAgICAgICAgIC5sYXN0KClcbiAgICAgICAgICAgICAgICAuZmluZCgnLmFkZF90b19jb2xsZWN0aW9uJylcbiAgICAgICAgICAgICAgICAuYXR0cigncGFyZW50X2NvdW50JywgcGFyZW50X2NvdW50KTtcbiAgICAgICAgfVxuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KVxuICAgICAgICAgICAgLnByZXYoKVxuICAgICAgICAgICAgLmZpbmQoJy53cmFwcGVkLWNoaWxkLWJvZHknKVxuICAgICAgICAgICAgLmxhc3QoKVxuICAgICAgICAgICAgLmZpbmQoJy5hZGRfdG9fY29sbGVjdGlvbicpXG4gICAgICAgICAgICAuYXR0cignd3JhcHBlcl9wYXJlbnRfY291bnQnLCB3cmFwcGVyX3BhcmVudF9jb3VudCAhPT0gbnVsbCAmJiB3cmFwcGVyX3BhcmVudF9jb3VudCAhPT0gdm9pZCAwID8gd3JhcHBlcl9wYXJlbnRfY291bnQgOiAwKTtcbiAgICAgICAgaWYgKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2Zvcm1fdHlwZScpKSB7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wcmV2KCkubGFzdCgpLmZpbmQoJy5zZWxlY3QyJykuc2VsZWN0Mih7XG4gICAgICAgICAgICAgICAgcGxhY2Vob2xkZXI6ICdTZWxlY3QgYW4gb3B0aW9uJyxcbiAgICAgICAgICAgICAgICBhbGxvd0NsZWFyOiB0cnVlLFxuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcbiAgICAgICAgICAgICAgICAuZmluZCgnLnN1Yi1hdHRyaWJ1dGUnKVxuICAgICAgICAgICAgICAgIC53cmFwQWxsKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnPGRpdiBjbGFzcz1cImZvcm0tZmllbGQtZ3JvdXAgZmxleCBmbGV4LXdyYXAgcm91bmRlZC1ici1sZyBib3JkZXIteSBib3JkZXItciBib3JkZXItc3ByaW5nLTUwIHN1Yi1hdHRyaWJ1dGUtd3JhcHBlclwiPjwvZGl2PicpKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXG4gICAgICAgICAgICAgICAgLnByZXYoJy5zdWJlbGVtZW50JylcbiAgICAgICAgICAgICAgICAuY2hpbGRyZW4oJy53cmFwcGVkLWNoaWxkLWJvZHknKVxuICAgICAgICAgICAgICAgIC5sYXN0KClcbiAgICAgICAgICAgICAgICAuZmluZCgnLnN1Yi1hdHRyaWJ1dGUnKVxuICAgICAgICAgICAgICAgIC53cmFwQWxsKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnPGRpdiBjbGFzcz1cImZvcm0tZmllbGQtZ3JvdXAgZmxleCBmbGV4LXdyYXAgcm91bmRlZC1ici1sZyBib3JkZXIteSBib3JkZXItciBib3JkZXItc3ByaW5nLTUwIHN1Yi1hdHRyaWJ1dGUtd3JhcHBlciBtdC02XCI+PC9kaXY+JykpO1xuICAgICAgICB9XG4gICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldClcbiAgICAgICAgICAgICAgICAucGFyZW50KClcbiAgICAgICAgICAgICAgICAuZmluZCgnLmZvcm0tY2hpbGQtYm9keScpXG4gICAgICAgICAgICAgICAgLmxhc3QoKVxuICAgICAgICAgICAgICAgIC5maW5kKCcuc2VsZWN0MicpXG4gICAgICAgICAgICAgICAgLnNlbGVjdDIoe1xuICAgICAgICAgICAgICAgIHBsYWNlaG9sZGVyOiAnU2VsZWN0IGFuIG9wdGlvbicsXG4gICAgICAgICAgICAgICAgYWxsb3dDbGVhcjogdHJ1ZSxcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2NoaWxkX2NvdW50JywgY291bnQpO1xuICAgICAgICBkeW5hbWljRmllbGQuYWlkVHlwZVZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgZHluYW1pY0ZpZWxkLnNlY3RvclZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICB9O1xuICAgIC8vIGFkZHMgcGFyZW50IGNvbGxlY3Rpb25cbiAgICBGb3JtQnVpbGRlci5wcm90b3R5cGUuYWRkUGFyZW50Rm9ybSA9IGZ1bmN0aW9uIChldikge1xuICAgICAgICBldi5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICB2YXIgdGFyZ2V0ID0gZXYudGFyZ2V0O1xuICAgICAgICB2YXIgY29udGFpbmVyID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignZm9ybV90eXBlJylcbiAgICAgICAgICAgID8gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKFwiLnBhcmVudC1jb2xsZWN0aW9uW2Zvcm1fdHlwZSA9J1wiLmNvbmNhdCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdmb3JtX3R5cGUnKSwgXCInXVwiKSlcbiAgICAgICAgICAgIDogKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcucGFyZW50LWNvbGxlY3Rpb24nKTtcbiAgICAgICAgdmFyIGNvdW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cigncGFyZW50X2NvdW50JylcbiAgICAgICAgICAgID8gcGFyc2VJbnQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cigncGFyZW50X2NvdW50JykpICsgMVxuICAgICAgICAgICAgOiAoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucHJldigpLmZpbmQoJy5tdWx0aS1mb3JtJykubGVuZ3RoXG4gICAgICAgICAgICAgICAgPyAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wcmV2KCkuZmluZCgnLm11bHRpLWZvcm0nKS5sZW5ndGhcbiAgICAgICAgICAgICAgICA6ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLnByZXYoKS5maW5kKCcud3JhcHBlZC1jaGlsZC1ib2R5JykubGVuZ3RoKSArIDE7XG4gICAgICAgIHZhciBwcm90byA9IGNvbnRhaW5lci5kYXRhKCdwcm90b3R5cGUnKS5yZXBsYWNlKC9fX1BBUkVOVF9OQU1FX18vZywgY291bnQpO1xuICAgICAgICBwcm90byA9IHByb3RvLnJlcGxhY2UoL19fTkFNRV9fL2csIDApO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wcmV2KCkuYXBwZW5kKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShwcm90bykpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wcmV2KCkuZmluZCgnLm11bHRpLWZvcm0nKS5sYXN0KCkuZmluZCgnLnNlbGVjdDInKS5zZWxlY3QyKHtcbiAgICAgICAgICAgIHBsYWNlaG9sZGVyOiAnU2VsZWN0IGFuIG9wdGlvbicsXG4gICAgICAgICAgICBhbGxvd0NsZWFyOiB0cnVlLFxuICAgICAgICB9KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldClcbiAgICAgICAgICAgIC5wcmV2KClcbiAgICAgICAgICAgIC5maW5kKCcubXVsdGktZm9ybScpXG4gICAgICAgICAgICAubGFzdCgpXG4gICAgICAgICAgICAuZmluZCgnLmFkZF90b19jb2xsZWN0aW9uJylcbiAgICAgICAgICAgIC5hdHRyKCdwYXJlbnRfY291bnQnLCBjb3VudCk7XG4gICAgICAgIHRoaXMuYWRkV3JhcHBlck9uQWRkKHRhcmdldCk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ3BhcmVudF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgZHluYW1pY0ZpZWxkLmh1bWFuaXRhcmlhblNjb3BlSGlkZVZvY2FidWxhcnlVcmkoKTtcbiAgICAgICAgZHluYW1pY0ZpZWxkLmNvdW50cnlCdWRnZXRIaWRlQ29kZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC5zZWN0b3JWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC5yZWNpcGllbnRWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC5wb2xpY3lWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC50YWdWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC50cmFuc2FjdGlvbkFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC5pbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGRVcmkoKTtcbiAgICB9O1xuICAgIC8vIGRlbGV0ZXMgY29sbGVjdGlvblxuICAgIEZvcm1CdWlsZGVyLnByb3RvdHlwZS5kZWxldGVGb3JtID0gZnVuY3Rpb24gKGV2KSB7XG4gICAgICAgIGV2LnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIHZhciB0YXJnZXQgPSBldi50YXJnZXQ7XG4gICAgICAgIHZhciBjb2xsZWN0aW9uTGVuZ3RoID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcubXVsdGktZm9ybScpLmxlbmd0aFxuICAgICAgICAgICAgPyAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5jbG9zZXN0KCcuc3ViZWxlbWVudCcpLmZpbmQoJy5mb3JtLWNoaWxkLWJvZHknKS5sZW5ndGhcbiAgICAgICAgICAgIDogKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuZm9ybS1jaGlsZC1ib2R5JykubGVuZ3RoO1xuICAgICAgICB2YXIgY291bnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5hZGRfdG9fY29sbGVjdGlvbicpLmF0dHIoJ2NoaWxkX2NvdW50JylcbiAgICAgICAgICAgID8gcGFyc2VJbnQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX2NvbGxlY3Rpb24nKS5hdHRyKCdjaGlsZF9jb3VudCcpKSArIDFcbiAgICAgICAgICAgIDogY29sbGVjdGlvbkxlbmd0aDtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX2NvbGxlY3Rpb24nKS5hdHRyKCdjaGlsZF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgaWYgKGNvbGxlY3Rpb25MZW5ndGggPiAxKSB7XG4gICAgICAgICAgICB2YXIgdGcgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5jbG9zZXN0KCcuZm9ybS1jaGlsZC1ib2R5Jyk7XG4gICAgICAgICAgICB0Zy5uZXh0KCcuZXJyb3InKS5yZW1vdmUoKTtcbiAgICAgICAgICAgIHRnLnJlbW92ZSgpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvLyBkZWxldGVzIHBhcmVudCBjb2xsZWN0aW9uXG4gICAgRm9ybUJ1aWxkZXIucHJvdG90eXBlLmRlbGV0ZVBhcmVudEZvcm0gPSBmdW5jdGlvbiAoZXYpIHtcbiAgICAgICAgZXYucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgdmFyIHRhcmdldCA9IGV2LnRhcmdldDtcbiAgICAgICAgdmFyIGNvbGxlY3Rpb25MZW5ndGggPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5zdWJlbGVtZW50JykubGVuZ3RoO1xuICAgICAgICB2YXIgY291bnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5hZGRfdG9fcGFyZW50JykuYXR0cignY2hpbGRfY291bnQnKVxuICAgICAgICAgICAgPyBwYXJzZUludCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5hZGRfdG9fcGFyZW50JykuYXR0cignY2hpbGRfY291bnQnKSkgKyAxXG4gICAgICAgICAgICA6IGNvbGxlY3Rpb25MZW5ndGg7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmFkZF90b19wYXJlbnQnKS5hdHRyKCdjaGlsZF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX3BhcmVudCcpLmF0dHIoJ3BhcmVudF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgaWYgKGNvbGxlY3Rpb25MZW5ndGggPiAyKSB7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wYXJlbnQoKS5yZW1vdmUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLy9hZGQgd3JhcHBlciBkaXYgYXJvdW5kIHRoZSBhdHRyaWJ1dGVzXG4gICAgRm9ybUJ1aWxkZXIucHJvdG90eXBlLmFkZFdyYXBwZXIgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLm11bHRpLWZvcm0nKS5lYWNoKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKVxuICAgICAgICAgICAgICAgIC5maW5kKCcuYXR0cmlidXRlJylcbiAgICAgICAgICAgICAgICAud3JhcEFsbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJzxkaXYgY2xhc3M9XCJmb3JtLWZpZWxkLWdyb3VwIGZsZXggZmxleC13cmFwIHJvdW5kZWQtYnItbGcgYm9yZGVyLXkgYm9yZGVyLXIgYm9yZGVyLXNwcmluZy01MCBhdHRyaWJ1dGUtd3JhcHBlciBtYi00XCI+PC9kaXY+JykpO1xuICAgICAgICB9KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuc3ViZWxlbWVudCcpXG4gICAgICAgICAgICAuZmluZCgnLndyYXBwZWQtY2hpbGQtYm9keScpXG4gICAgICAgICAgICAuZWFjaChmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcbiAgICAgICAgICAgICAgICAuZmluZCgnLnN1Yi1hdHRyaWJ1dGUnKVxuICAgICAgICAgICAgICAgIC53cmFwQWxsKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnPGRpdiBjbGFzcz1cImZvcm0tZmllbGQtZ3JvdXAgZmxleCBmbGV4LXdyYXAgcm91bmRlZC1ici1sZyBib3JkZXIteSBib3JkZXItciBib3JkZXItc3ByaW5nLTUwIHN1Yi1hdHRyaWJ1dGUtd3JhcHBlciBtYi00XCI+PC9kaXY+JykpO1xuICAgICAgICB9KTtcbiAgICAgICAgdmFyIGZvcm1GaWVsZCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnZm9ybT4uZm9ybS1maWVsZCcpO1xuICAgICAgICBpZiAoZm9ybUZpZWxkLmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIGZvcm1GaWVsZC53cmFwQWxsKCc8ZGl2IGNsYXNzPVwiZm9ybS1maWVsZC1ncm91cC1vdXRlciBncmlkIHhsOmdyaWQtY29scy0yIG1iLTYgLW14LTMgZ2FwLXktNlwiPjwvZGl2PicpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICBGb3JtQnVpbGRlci5wcm90b3R5cGUuYWRkV3JhcHBlck9uQWRkID0gZnVuY3Rpb24gKHRhcmdldCkge1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KVxuICAgICAgICAgICAgLnByZXYoKVxuICAgICAgICAgICAgLmZpbmQoJy5tdWx0aS1mb3JtJylcbiAgICAgICAgICAgIC5sYXN0KClcbiAgICAgICAgICAgIC5maW5kKCcuYXR0cmlidXRlJylcbiAgICAgICAgICAgIC53cmFwQWxsKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnPGRpdiBjbGFzcz1cImZvcm0tZmllbGQtZ3JvdXAgZ3JpZCB4bDpncmlkLWNvbHMtMiByb3VuZGVkLWJyLWxnIGJvcmRlci15IGJvcmRlci1yIGJvcmRlci1zcHJpbmctNTAgYXR0cmlidXRlLXdyYXBwZXIgbWItNFwiPjwvZGl2PicpKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldClcbiAgICAgICAgICAgIC5wcmV2KClcbiAgICAgICAgICAgIC5maW5kKCcubXVsdGktZm9ybScpXG4gICAgICAgICAgICAubGFzdCgpXG4gICAgICAgICAgICAuZmluZCgnLnN1YmVsZW1lbnQnKVxuICAgICAgICAgICAgLmZpbmQoJy53cmFwcGVkLWNoaWxkLWJvZHknKVxuICAgICAgICAgICAgLmVhY2goZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpXG4gICAgICAgICAgICAgICAgLmZpbmQoJy5zdWItYXR0cmlidXRlJylcbiAgICAgICAgICAgICAgICAud3JhcEFsbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJzxkaXYgY2xhc3M9XCJmb3JtLWZpZWxkLWdyb3VwIGZsZXggZmxleC13cmFwIHJvdW5kZWQtYnItbGcgYm9yZGVyLXkgYm9yZGVyLXIgYm9yZGVyLXNwcmluZy01MCBzdWItYXR0cmlidXRlLXdyYXBwZXIgbWItNFwiPjwvZGl2PicpKTtcbiAgICAgICAgfSk7XG4gICAgfTtcbiAgICBGb3JtQnVpbGRlci5wcm90b3R5cGUudGV4dEFyZWFIZWlnaHQgPSBmdW5jdGlvbiAoZXYpIHtcbiAgICAgICAgdmFyIHRhcmdldCA9IGV2LnRhcmdldDtcbiAgICAgICAgdmFyIGhlaWdodCA9IHRhcmdldC5zY3JvbGxIZWlnaHQ7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmNzcygnaGVpZ2h0JywgaGVpZ2h0KTtcbiAgICB9O1xuICAgIEZvcm1CdWlsZGVyLnByb3RvdHlwZS5hZGRUb0NvbGxlY3Rpb24gPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsICcuYWRkX3RvX2NvbGxlY3Rpb24nLCBmdW5jdGlvbiAoZXZlbnQpIHtcbiAgICAgICAgICAgIGlmICgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoZXZlbnQudGFyZ2V0KS5oYXNDbGFzcygnYWRkLWljb24nKSkge1xuICAgICAgICAgICAgICAgIGV2ZW50LnN0b3BQcm9wYWdhdGlvbigpO1xuICAgICAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShldmVudC50YXJnZXQpXG4gICAgICAgICAgICAgICAgICAgIC5wYXJlbnQoJ2J1dHRvbicpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjbGljaycpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZWxzZSB7XG4gICAgICAgICAgICAgICAgX3RoaXMuYWRkRm9ybShldmVudCk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH0pO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5hZGRfdG9fcGFyZW50Jykub24oJ2NsaWNrJywgZnVuY3Rpb24gKGV2ZW50KSB7XG4gICAgICAgICAgICBpZiAoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGV2ZW50LnRhcmdldCkuaGFzQ2xhc3MoJ2FkZC1pY29uJykpIHtcbiAgICAgICAgICAgICAgICBldmVudC5zdG9wUHJvcGFnYXRpb24oKTtcbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoZXZlbnQudGFyZ2V0KVxuICAgICAgICAgICAgICAgICAgICAucGFyZW50KCdidXR0b24nKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2xpY2snKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgICAgIF90aGlzLmFkZFBhcmVudEZvcm0oZXZlbnQpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcbiAgICB9O1xuICAgIEZvcm1CdWlsZGVyLnByb3RvdHlwZS5kZWxldGVDb2xsZWN0aW9uID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuICAgICAgICB2YXIgZGVsZXRlQ29uZmlybWF0aW9uID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuZGVsZXRlLWNvbmZpcm1hdGlvbicpLCBjYW5jZWxQb3B1cCA9ICcuY2FuY2VsLXBvcHVwJywgZGVsZXRlQ29uZmlybSA9ICcuZGVsZXRlLWNvbmZpcm0nO1xuICAgICAgICB2YXIgZGVsZXRlSW5kZXggPSB7fSwgY2hpbGRPclBhcmVudCA9ICcnO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCAnLmRlbGV0ZScsIGZ1bmN0aW9uIChldmVudCkge1xuICAgICAgICAgICAgZGVsZXRlQ29uZmlybWF0aW9uLmZhZGVJbigpO1xuICAgICAgICAgICAgZGVsZXRlSW5kZXggPSBldmVudDtcbiAgICAgICAgICAgIGNoaWxkT3JQYXJlbnQgPSAnY2hpbGQnO1xuICAgICAgICB9KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgY2FuY2VsUG9wdXAsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgIGRlbGV0ZUNvbmZpcm1hdGlvbi5mYWRlT3V0KCk7XG4gICAgICAgICAgICBkZWxldGVJbmRleCA9IHt9O1xuICAgICAgICAgICAgY2hpbGRPclBhcmVudCA9ICcnO1xuICAgICAgICB9KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgZGVsZXRlQ29uZmlybSwgZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgaWYgKGNoaWxkT3JQYXJlbnQgPT09ICdjaGlsZCcpIHtcbiAgICAgICAgICAgICAgICBfdGhpcy5kZWxldGVGb3JtKGRlbGV0ZUluZGV4KTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2UgaWYgKGNoaWxkT3JQYXJlbnQgPT09ICdwYXJlbnQnKSB7XG4gICAgICAgICAgICAgICAgX3RoaXMuZGVsZXRlUGFyZW50Rm9ybShkZWxldGVJbmRleCk7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBkZWxldGVDb25maXJtYXRpb24uZmFkZU91dCgpO1xuICAgICAgICAgICAgZGVsZXRlSW5kZXggPSB7fTtcbiAgICAgICAgICAgIGNoaWxkT3JQYXJlbnQgPSAnJztcbiAgICAgICAgfSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsICcuZGVsZXRlLXBhcmVudCcsIGZ1bmN0aW9uIChldmVudCkge1xuICAgICAgICAgICAgZGVsZXRlQ29uZmlybWF0aW9uLmZhZGVJbigpO1xuICAgICAgICAgICAgZGVsZXRlSW5kZXggPSBldmVudDtcbiAgICAgICAgICAgIGNoaWxkT3JQYXJlbnQgPSAncGFyZW50JztcbiAgICAgICAgfSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLnNlbGVjdDInKS5zZWxlY3QyKHtcbiAgICAgICAgICAgIHBsYWNlaG9sZGVyOiAnU2VsZWN0IGFuIG9wdGlvbicsXG4gICAgICAgICAgICBhbGxvd0NsZWFyOiB0cnVlLFxuICAgICAgICB9KTtcbiAgICAgICAgLy8gdXBkYXRlIGZvcm1hdCBvbiBjaGFuZ2Ugb2YgZG9jdW1lbnQgbGlua1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2hhbmdlJywgJ2lucHV0W2lkKj1cIlt1cmxdXCJdJywgZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKCdyZW1vdmluZycpO1xuICAgICAgICAgICAgdmFyIGZpbGVQYXRoID0gKChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJycpLnRvU3RyaW5nKCk7XG4gICAgICAgICAgICB2YXIgdXJsID0gXCIvbWltZXR5cGU/dXJsPVwiLmNvbmNhdChmaWxlUGF0aCwgXCImdHlwZT11cmxcIik7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykuY2xvc2VzdCgnLmZvcm0tZmllbGQnKS5maW5kKCcudGV4dC1kYW5nZXInKS5yZW1vdmUoKTtcbiAgICAgICAgICAgIGlmIChmaWxlUGF0aCAhPT0gJycpIHtcbiAgICAgICAgICAgICAgICBheGlvc18xLmRlZmF1bHQuZ2V0KHVybCkudGhlbihmdW5jdGlvbiAocmVzcG9uc2UpIHtcbiAgICAgICAgICAgICAgICAgICAgaWYgKHJlc3BvbnNlLmRhdGEuc3VjY2Vzcykge1xuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGZvcm1hdCA9IHJlc3BvbnNlLmRhdGEuZGF0YS5taW1ldHlwZTtcbiAgICAgICAgICAgICAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShfdGhpcylcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC5maW5kKCdzZWxlY3RbaWQqPVwiW2Zvcm1hdF1cIl0nKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC52YWwoZm9ybWF0KVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShfdGhpcykuY2xvc2VzdCgnLmZvcm0tZmllbGQnKS5maW5kKCcudGV4dC1kYW5nZXInKS5yZW1vdmUoKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShfdGhpcykuY2xvc2VzdCgnLmZvcm0tZmllbGQnKS5hcHBlbmQoXCI8ZGl2IGNsYXNzPSd0ZXh0LWRhbmdlciBlcnJvcic+XCIgKyByZXNwb25zZS5kYXRhLm1lc3NhZ2UgKyBcIjwvZGl2PlwiKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShfdGhpcylcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC5maW5kKCdzZWxlY3RbaWQqPVwiW2Zvcm1hdF1cIl0nKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKCdpbnB1dFtpZCo9XCJbZG9jdW1lbnRdXCJdJylcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NoYW5nZScsICdpbnB1dFtpZCo9XCJbZG9jdW1lbnRdXCJdJywgZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKCdkb2N1bWVudCcpO1xuICAgICAgICAgICAgdmFyIGZpbGVQYXRoID0gKChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJycpLnRvU3RyaW5nKCk7XG4gICAgICAgICAgICB2YXIgdXJsID0gXCIvbWltZXR5cGU/dXJsPVwiLmNvbmNhdChmaWxlUGF0aCwgXCImJnR5cGU9ZG9jdW1lbnRcIik7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykuY2xvc2VzdCgnLmZvcm0tZmllbGQnKS5maW5kKCcudGV4dC1kYW5nZXInKS5yZW1vdmUoKTtcbiAgICAgICAgICAgIGlmIChmaWxlUGF0aCAhPT0gJycpIHtcbiAgICAgICAgICAgICAgICBheGlvc18xLmRlZmF1bHQuZ2V0KHVybCkudGhlbihmdW5jdGlvbiAocmVzcG9uc2UpIHtcbiAgICAgICAgICAgICAgICAgICAgaWYgKHJlc3BvbnNlLmRhdGEuc3VjY2Vzcykge1xuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGZvcm1hdCA9IHJlc3BvbnNlLmRhdGEuZGF0YS5taW1ldHlwZTtcbiAgICAgICAgICAgICAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShfdGhpcylcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC5maW5kKCdzZWxlY3RbaWQqPVwiW2Zvcm1hdF1cIl0nKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC52YWwoZm9ybWF0KVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShfdGhpcylcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC5maW5kKCdzZWxlY3RbaWQqPVwiW2Zvcm1hdF1cIl0nKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKCdpbnB1dFtpZCo9XCJbdXJsXVwiXScpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKVxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgLmZpbmQoJ3NlbGVjdFtpZCo9XCJbZm9ybWF0XVwiXScpXG4gICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJyk7XG4gICAgICAgIH0pO1xuICAgIH07XG4gICAgcmV0dXJuIEZvcm1CdWlsZGVyO1xufSgpKTtcbigwLCBqcXVlcnlfMS5kZWZhdWx0KShmdW5jdGlvbiAoKSB7XG4gICAgdmFyIGZvcm1CdWlsZGVyID0gbmV3IEZvcm1CdWlsZGVyKCk7XG4gICAgZm9ybUJ1aWxkZXIuYWRkV3JhcHBlcigpO1xuICAgIGR5bmFtaWNGaWVsZC5oaWRlU2hvd0Zvcm1GaWVsZHMoKTtcbiAgICBkeW5hbWljRmllbGQudXBkYXRlQWN0aXZpdHlJZGVudGlmaWVyKCk7XG4gICAgZm9ybUJ1aWxkZXIuYWRkVG9Db2xsZWN0aW9uKCk7XG4gICAgZm9ybUJ1aWxkZXIuZGVsZXRlQ29sbGVjdGlvbigpO1xuICAgIC8qKlxuICAgICAqIFRleHQgYXJlYSBoZWlnaHQgb24gdHlwaW5nXG4gICAgICovXG4gICAgdmFyIHRleHRBcmVhVGFyZ2V0ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCd0ZXh0YXJlYS5mb3JtX19pbnB1dCcpO1xuICAgIGlmICh0ZXh0QXJlYVRhcmdldC5sZW5ndGggPiAwKSB7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdpbnB1dCcsICd0ZXh0YXJlYS5mb3JtX19pbnB1dCcsIGZ1bmN0aW9uIChldmVudCkge1xuICAgICAgICAgICAgZm9ybUJ1aWxkZXIudGV4dEFyZWFIZWlnaHQoZXZlbnQpO1xuICAgICAgICB9KTtcbiAgICB9XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ3NlbGVjdDI6b3BlbicsICcuc2VsZWN0MicsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIHNlbGVjdF9zZWFyY2ggPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcuc2VsZWN0Mi1zZWFyY2hfX2ZpZWxkJyk7XG4gICAgICAgIGlmIChzZWxlY3Rfc2VhcmNoKSB7XG4gICAgICAgICAgICBzZWxlY3Rfc2VhcmNoLmZvY3VzKCk7XG4gICAgICAgIH1cbiAgICB9KTtcbiAgICAvKipcbiAgICAgKiBjaGVja3MgcmVnaXN0cmF0aW9uIGFnZW5jeSwgY291bnRyeSBhbmQgcmVnaXN0cmF0aW9uIG51bWJlciB0byBkZWR1Y2UgaWRlbnRpZmllclxuICAgICAqL1xuICAgIHVwZGF0ZVJlZ2lzdHJhdGlvbkFnZW5jeSgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbml6YXRpb25fY291bnRyeScpKTtcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbmlzYXRpb25faWRlbnRpZmllcicpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJyk7XG4gICAgZnVuY3Rpb24gdXBkYXRlUmVnaXN0cmF0aW9uQWdlbmN5KGNvdW50cnkpIHtcbiAgICAgICAgaWYgKGNvdW50cnkudmFsKCkpIHtcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuYWpheCh7IHVybDogJy9vcmdhbmlzYXRpb24vYWdlbmN5LycgKyBjb3VudHJ5LnZhbCgpIH0pLnRoZW4oZnVuY3Rpb24gKHJlc3BvbnNlKSB7XG4gICAgICAgICAgICAgICAgdmFyIF9hO1xuICAgICAgICAgICAgICAgIHZhciBjdXJyZW50X3ZhbCA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI29yZ2FuaXphdGlvbl9yZWdpc3RyYXRpb25fYWdlbmN5JykudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcnO1xuICAgICAgICAgICAgICAgIHZhciB2YWwgPSBmYWxzZTtcbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScpLmVtcHR5KCk7XG4gICAgICAgICAgICAgICAgZm9yICh2YXIgZGF0YSBpbiByZXNwb25zZS5kYXRhKSB7XG4gICAgICAgICAgICAgICAgICAgIGlmIChkYXRhID09PSBjdXJyZW50X3ZhbCkge1xuICAgICAgICAgICAgICAgICAgICAgICAgdmFsID0gdHJ1ZTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScpXG4gICAgICAgICAgICAgICAgICAgICAgICAuYXBwZW5kKG5ldyBPcHRpb24ocmVzcG9uc2UuZGF0YVtkYXRhXSwgZGF0YSwgdHJ1ZSwgdHJ1ZSkpXG4gICAgICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScpXG4gICAgICAgICAgICAgICAgICAgIC52YWwodmFsID8gY3VycmVudF92YWwgOiAnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ3NlbGVjdDI6c2VsZWN0JywgJyNvcmdhbml6YXRpb25fY291bnRyeScsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdXBkYXRlUmVnaXN0cmF0aW9uQWdlbmN5KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKSk7XG4gICAgfSk7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ3NlbGVjdDI6c2VsZWN0JywgJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIGlkZW50aWZpZXIgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykudmFsKCkgKyAnLScgKyAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNyZWdpc3RyYXRpb25fbnVtYmVyJykudmFsKCk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI29yZ2FuaXNhdGlvbl9pZGVudGlmaWVyJykudmFsKGlkZW50aWZpZXIpO1xuICAgIH0pO1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdzZWxlY3QyOmNsZWFyJywgJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIGlkZW50aWZpZXIgPSAnLScgKyAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNyZWdpc3RyYXRpb25fbnVtYmVyJykudmFsKCk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI29yZ2FuaXNhdGlvbl9pZGVudGlmaWVyJykudmFsKGlkZW50aWZpZXIpO1xuICAgIH0pO1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdrZXl1cCcsICcjcmVnaXN0cmF0aW9uX251bWJlcicsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIGlkZW50aWZpZXIgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScpLnZhbCgpICsgJy0nICsgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpLnZhbCgpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbmlzYXRpb25faWRlbnRpZmllcicpLnZhbChpZGVudGlmaWVyKTtcbiAgICB9KTtcbiAgICAvLyBhZGQgY2xhc3MgdG8gdGl0bGUgb2YgY29sbGVjdGlvbiB3aGVuIHZhbGlkYXRpb24gZXJyb3Igb2NjdXJzIG9uIGNvbGxlY3Rpb24gbGV2ZWxcbiAgICB2YXIgc3ViZWxlbWVudCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJy5zdWJlbGVtZW50Jyk7XG4gICAgZm9yICh2YXIgaSA9IDA7IGkgPCBzdWJlbGVtZW50Lmxlbmd0aDsgaSsrKSB7XG4gICAgICAgIHZhciB0aXRsZSA9IHN1YmVsZW1lbnRbaV0ucXVlcnlTZWxlY3RvcignLmNvbnRyb2wtbGFiZWwnKTtcbiAgICAgICAgdmFyIGVycm9yQ29udGFpbmVyID0gc3ViZWxlbWVudFtpXS5xdWVyeVNlbGVjdG9yKCcuY29sbGVjdGlvbl9lcnJvcicpO1xuICAgICAgICB2YXIgY2hpbGRDb3VudCA9IGVycm9yQ29udGFpbmVyID09PSBudWxsIHx8IGVycm9yQ29udGFpbmVyID09PSB2b2lkIDAgPyB2b2lkIDAgOiBlcnJvckNvbnRhaW5lci5jaGlsZEVsZW1lbnRDb3VudDtcbiAgICAgICAgaWYgKGNoaWxkQ291bnQgJiYgY2hpbGRDb3VudCA+IDApIHtcbiAgICAgICAgICAgIHRpdGxlID09PSBudWxsIHx8IHRpdGxlID09PSB2b2lkIDAgPyB2b2lkIDAgOiB0aXRsZS5jbGFzc0xpc3QuYWRkKCdlcnJvci10aXRsZScpO1xuICAgICAgICB9XG4gICAgfVxuICAgIC8vIEFkZGluZyBjdXJzb3Igbm90IGFsbG93ZWQgdG8gPHNlbGVjdD4gd2hlcmUgZWxlbWVudEpzb25TY2hlbWEgcmVhZF9vbmx5IDogdHJ1ZVxuICAgIHZhciByZWFkT25seVNlbGVjdHMgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKFwic2VsZWN0LmN1cnNvci1ub3QtYWxsb3dlZFwiKTtcbiAgICBmb3IgKHZhciBpID0gMDsgaSA8IHJlYWRPbmx5U2VsZWN0cy5sZW5ndGg7IGkrKykge1xuICAgICAgICB2YXIgc2VsZWN0ID0gcmVhZE9ubHlTZWxlY3RzW2ldO1xuICAgICAgICB2YXIgc2VsZWN0RWxlbWVudFBhcmVudFdyYXBwZXIgPSBzZWxlY3QubmV4dFNpYmxpbmc7XG4gICAgICAgIHZhciBzZWxlY3RFbGVtZW50UGFyZW50ID0gc2VsZWN0RWxlbWVudFBhcmVudFdyYXBwZXIgPT09IG51bGwgfHwgc2VsZWN0RWxlbWVudFBhcmVudFdyYXBwZXIgPT09IHZvaWQgMCA/IHZvaWQgMCA6IHNlbGVjdEVsZW1lbnRQYXJlbnRXcmFwcGVyLmZpcnN0Q2hpbGQ7XG4gICAgICAgIHZhciBzZWxlY3RFbGVtZW50ID0gc2VsZWN0RWxlbWVudFBhcmVudCA9PT0gbnVsbCB8fCBzZWxlY3RFbGVtZW50UGFyZW50ID09PSB2b2lkIDAgPyB2b2lkIDAgOiBzZWxlY3RFbGVtZW50UGFyZW50LmZpcnN0Q2hpbGQ7XG4gICAgICAgIGlmIChzZWxlY3RFbGVtZW50KSB7XG4gICAgICAgICAgICBzZWxlY3RFbGVtZW50LnN0eWxlLmN1cnNvciA9IFwibm90LWFsbG93ZWRcIjtcbiAgICAgICAgfVxuICAgIH1cbn0pO1xuIl0sIm5hbWVzIjpbIl9faW1wb3J0RGVmYXVsdCIsIm1vZCIsIl9fZXNNb2R1bGUiLCJPYmplY3QiLCJkZWZpbmVQcm9wZXJ0eSIsImV4cG9ydHMiLCJ2YWx1ZSIsIkR5bmFtaWNGaWVsZCIsImpxdWVyeV8xIiwicmVxdWlyZSIsInByb3RvdHlwZSIsImhpZGVTaG93Rm9ybUZpZWxkcyIsImh1bWFuaXRhcmlhblNjb3BlSGlkZVZvY2FidWxhcnlVcmkiLCJjb3VudHJ5QnVkZ2V0SGlkZUNvZGVGaWVsZCIsImFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkIiwic2VjdG9yVm9jYWJ1bGFyeUhpZGVGaWVsZCIsInBvbGljeVZvY2FidWxhcnlIaWRlRmllbGQiLCJyZWNpcGllbnRWb2NhYnVsYXJ5SGlkZUZpZWxkIiwidGFnVm9jYWJ1bGFyeUhpZGVGaWVsZCIsInRyYW5zYWN0aW9uQWlkVHlwZVZvY2FidWxhcnlIaWRlRmllbGQiLCJpbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGRVcmkiLCJfdGhpcyIsImh1bWFuaXRhcmlhblNjb3BlVm9jYWJ1bGFyeSIsImxlbmd0aCIsImVhY2giLCJpbmRleCIsInNjb3BlIiwiX2EiLCJ2YWwiLCJoaWRlSHVtYW5pdGFyaWFuU2NvcGVGaWVsZCIsInRvU3RyaW5nIiwib24iLCJlIiwicGFyYW1zIiwiZGF0YSIsImlkIiwidGFyZ2V0IiwiY2xvc2VzdCIsImZpbmQiLCJzaG93IiwicmVtb3ZlQXR0ciIsInRyaWdnZXIiLCJoaWRlIiwiYXR0ciIsInJlZmVyZW5jZVZvY2FidWxhcnkiLCJpbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGQiLCJyZWZlcmVuY2VVcmkiLCJjb3VudHJ5QnVkZ2V0Vm9jYWJ1bGFyeSIsImhpZGVDb3VudHJ5QnVkZ2V0RmllbGQiLCJjb3VudHJ5QnVkZ2V0Q29kZUlucHV0IiwiY291bnRyeUJ1ZGdldENvZGVTZWxlY3QiLCJhaWR0eXBlX3ZvY2FidWxhcnkiLCJpdGVtIiwiaGlkZUFpZFR5cGVTZWxlY3RGaWVsZCIsImhpZGVUcmFuc2FjdGlvbkFpZFR5cGVTZWxlY3RGaWVsZCIsImRlZmF1bHRfYWlkX3R5cGUiLCJlYXJtYXJraW5nX2NhdGVnb3J5IiwiZWFybWFya2luZ19tb2RhbGl0eSIsImNhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllcyIsImNhc2UxIiwiY2FzZTIiLCJjYXNlMyIsImNhc2U0IiwiYWlkX3R5cGUiLCJwb2xpY3ltYWtlcl92b2NhYnVsYXJ5IiwicG9saWN5X21hcmtlciIsImhpZGVQb2xpY3lNYWtlckZpZWxkIiwiY2FzZTFfc2hvdyIsImNhc2UyX3Nob3ciLCJzZWN0b3Jfdm9jYWJ1bGFyeSIsInNlY3RvciIsImhpZGVTZWN0b3JGaWVsZCIsImNhc2U3X3Nob3ciLCJjYXNlOF9zaG93IiwiY2FzZTk4Xzk5X3Nob3ciLCJkZWZhdWx0X3Nob3ciLCJjYXNlNyIsImNhc2U4IiwiY2FzZTk4Xzk5IiwiZGVmYXVsdF9oaWRlIiwicmVnaW9uX3ZvY2FidWxhcnkiLCJyZWdpb25fdm9jYWIiLCJoaWRlUmVjaXBpZW50UmVnaW9uRmllbGQiLCJjYXNlOTlfc2hvdyIsImNhc2U5OSIsInVwZGF0ZUFjdGl2aXR5SWRlbnRpZmllciIsImFjdGl2aXR5X2lkZW50aWZpZXIiLCJjb25jYXQiLCJ0YWdfdm9jYWJ1bGFyeSIsInRhZyIsImhpZGVUYWdGaWVsZCIsImNhc2UzX3Nob3ciLCJheGlvc18xIiwiRHluYW1pY0ZpZWxkXzEiLCJkeW5hbWljRmllbGQiLCJGb3JtQnVpbGRlciIsImFkZEZvcm0iLCJldiIsInByZXZlbnREZWZhdWx0IiwiY29udGFpbmVyIiwiY291bnQiLCJwYXJzZUludCIsInBhcmVudCIsInBhcmVudF9jb3VudCIsInBhcmVudHMiLCJ3cmFwcGVyX3BhcmVudF9jb3VudCIsInByb3RvIiwicmVwbGFjZSIsInByZXYiLCJhcHBlbmQiLCJjaGlsZHJlbiIsImxhc3QiLCJzZWxlY3QyIiwicGxhY2Vob2xkZXIiLCJhbGxvd0NsZWFyIiwid3JhcEFsbCIsImFkZFBhcmVudEZvcm0iLCJhZGRXcmFwcGVyT25BZGQiLCJkZWxldGVGb3JtIiwiY29sbGVjdGlvbkxlbmd0aCIsInRnIiwibmV4dCIsInJlbW92ZSIsImRlbGV0ZVBhcmVudEZvcm0iLCJhZGRXcmFwcGVyIiwiZm9ybUZpZWxkIiwidGV4dEFyZWFIZWlnaHQiLCJoZWlnaHQiLCJzY3JvbGxIZWlnaHQiLCJjc3MiLCJhZGRUb0NvbGxlY3Rpb24iLCJldmVudCIsImhhc0NsYXNzIiwic3RvcFByb3BhZ2F0aW9uIiwiZGVsZXRlQ29sbGVjdGlvbiIsImRlbGV0ZUNvbmZpcm1hdGlvbiIsImNhbmNlbFBvcHVwIiwiZGVsZXRlQ29uZmlybSIsImRlbGV0ZUluZGV4IiwiY2hpbGRPclBhcmVudCIsImZhZGVJbiIsImZhZGVPdXQiLCJjb25zb2xlIiwibG9nIiwiZmlsZVBhdGgiLCJ1cmwiLCJnZXQiLCJ0aGVuIiwicmVzcG9uc2UiLCJzdWNjZXNzIiwiZm9ybWF0IiwibWltZXR5cGUiLCJtZXNzYWdlIiwiZm9ybUJ1aWxkZXIiLCJ0ZXh0QXJlYVRhcmdldCIsInNlbGVjdF9zZWFyY2giLCJkb2N1bWVudCIsInF1ZXJ5U2VsZWN0b3IiLCJmb2N1cyIsInVwZGF0ZVJlZ2lzdHJhdGlvbkFnZW5jeSIsImNvdW50cnkiLCJhamF4IiwiY3VycmVudF92YWwiLCJlbXB0eSIsIk9wdGlvbiIsImlkZW50aWZpZXIiLCJzdWJlbGVtZW50IiwicXVlcnlTZWxlY3RvckFsbCIsImkiLCJ0aXRsZSIsImVycm9yQ29udGFpbmVyIiwiY2hpbGRDb3VudCIsImNoaWxkRWxlbWVudENvdW50IiwiY2xhc3NMaXN0IiwiYWRkIiwicmVhZE9ubHlTZWxlY3RzIiwic2VsZWN0Iiwic2VsZWN0RWxlbWVudFBhcmVudFdyYXBwZXIiLCJuZXh0U2libGluZyIsInNlbGVjdEVsZW1lbnRQYXJlbnQiLCJmaXJzdENoaWxkIiwic2VsZWN0RWxlbWVudCIsInN0eWxlIiwiY3Vyc29yIl0sInNvdXJjZVJvb3QiOiIifQ==
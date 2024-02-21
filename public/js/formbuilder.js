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

      var filePath = ((_a = (0, jquery_1["default"])(this).val()) !== null && _a !== void 0 ? _a : '').toString();
      var document = (0, jquery_1["default"])(this).closest('.form-field-group').find('input[id*="[document]"]').val();
      var url = "/mimetype?url=".concat(filePath, "&type=url");
      (0, jquery_1["default"])(this).closest('.form-field').find('.text-danger').remove();

      if (filePath !== '') {
        axios_1["default"].get(url).then(function (response) {
          if (response.data.success) {
            var format = response.data.data.mimetype;
            (0, jquery_1["default"])(_this).closest('.form-field-group').find('select[id*="[format]"]').val(format).trigger('change');
          } else {
            (0, jquery_1["default"])(_this).closest('.form-field').find('.text-danger').remove();
            (0, jquery_1["default"])(_this).closest('.form-field').append("<div class='text-danger error'>" + response.data.message + '</div>');
            (0, jquery_1["default"])(_this).closest('.form-field-group').find('select[id*="[format]"]').val('').trigger('change');
          }

          (0, jquery_1["default"])(_this).closest('.form-field-group').find('input[id*="[document]"]').val('').trigger('change');
        });
      } else if (!document || document === '') {
        (0, jquery_1["default"])(this).closest('.form-field-group').find('select[id*="[format]"]').val('').trigger('change');
      }
    });
    (0, jquery_1["default"])('body').on('change', 'input[id*="[document]"]', function () {
      var _this = this;

      var _a;

      var filePath = ((_a = (0, jquery_1["default"])(this).val()) !== null && _a !== void 0 ? _a : '').toString();
      var url = "/mimetype?url=".concat(filePath, "&&type=document");
      var fileUrl = (0, jquery_1["default"])(this).closest('.form-field-group').find('input[id*="[url]"]').val();
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
      } else if (!fileUrl || fileUrl === '') {
        (0, jquery_1["default"])(this).closest('.form-field-group').find('select[id*="[format]"]').val('').trigger('change');
      }
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

  (0, jquery_1["default"])('body').on('select2:select', '#organization_country', function () {
    updateRegistrationAgency((0, jquery_1["default"])(this));
  });
  (0, jquery_1["default"])('body').on('select2:clear', '#organization_country', function () {
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


  var readOnlySelects = document.querySelectorAll('select.cursor-not-allowed');

  for (var i = 0; i < readOnlySelects.length; i++) {
    var select = readOnlySelects[i];
    var selectElementParentWrapper = select.nextSibling;
    var selectElementParent = selectElementParentWrapper === null || selectElementParentWrapper === void 0 ? void 0 : selectElementParentWrapper.firstChild;
    var selectElement = selectElementParent === null || selectElementParent === void 0 ? void 0 : selectElementParent.firstChild;

    if (selectElement) {
      selectElement.style.cursor = 'not-allowed';
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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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Y0ZpZWxkLnRzIiwid2VicGFjazovLy8uL3Jlc291cmNlcy9hc3NldHMvanMvc2NyaXB0cy9mb3JtYnVpbGRlci50cyJdLCJzb3VyY2VzQ29udGVudCI6WyJcInVzZSBzdHJpY3RcIjtcbnZhciBfX2ltcG9ydERlZmF1bHQgPSAodGhpcyAmJiB0aGlzLl9faW1wb3J0RGVmYXVsdCkgfHwgZnVuY3Rpb24gKG1vZCkge1xuICAgIHJldHVybiAobW9kICYmIG1vZC5fX2VzTW9kdWxlKSA/IG1vZCA6IHsgXCJkZWZhdWx0XCI6IG1vZCB9O1xufTtcbk9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBcIl9fZXNNb2R1bGVcIiwgeyB2YWx1ZTogdHJ1ZSB9KTtcbmV4cG9ydHMuRHluYW1pY0ZpZWxkID0gdm9pZCAwO1xudmFyIGpxdWVyeV8xID0gX19pbXBvcnREZWZhdWx0KHJlcXVpcmUoXCJqcXVlcnlcIikpO1xucmVxdWlyZShcInNlbGVjdDJcIik7XG52YXIgRHluYW1pY0ZpZWxkID0gLyoqIEBjbGFzcyAqLyAoZnVuY3Rpb24gKCkge1xuICAgIGZ1bmN0aW9uIER5bmFtaWNGaWVsZCgpIHtcbiAgICB9XG4gICAgLyoqXG4gICAgICogSGlkZSBhbmQgU2hvdyBkaWZmZXJlbnQgZm9ybSBmaWVsZHMgYmFzZWQgb24gdm9jYWJ1bGFyeSBhbmQgb3RoZXIgdHlwZXNcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmhpZGVTaG93Rm9ybUZpZWxkcyA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdGhpcy5odW1hbml0YXJpYW5TY29wZUhpZGVWb2NhYnVsYXJ5VXJpKCk7XG4gICAgICAgIHRoaXMuY291bnRyeUJ1ZGdldEhpZGVDb2RlRmllbGQoKTtcbiAgICAgICAgdGhpcy5haWRUeXBlVm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICB0aGlzLnNlY3RvclZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgdGhpcy5wb2xpY3lWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIHRoaXMucmVjaXBpZW50Vm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICB0aGlzLnNlY3RvclZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgdGhpcy50YWdWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIHRoaXMudHJhbnNhY3Rpb25BaWRUeXBlVm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICB0aGlzLmluZGljYXRvclJlZmVyZW5jZUhpZGVGaWVsZFVyaSgpO1xuICAgIH07XG4gICAgLyoqXG4gICAgICogSHVtYW5pdGFyaWFuIFNjb3BlIEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaHVtYW5pdGFyaWFuU2NvcGVIaWRlVm9jYWJ1bGFyeVVyaSA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgdmFyIGh1bWFuaXRhcmlhblNjb3BlVm9jYWJ1bGFyeSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnc2VsZWN0W2lkXj1cImh1bWFuaXRhcmlhbl9zY29wZVwiXVtpZCo9XCJbdm9jYWJ1bGFyeV1cIl0nKTtcbiAgICAgICAgaWYgKGh1bWFuaXRhcmlhblNjb3BlVm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICAvLyBoaWRlIGZpZWxkcyBvbiBwYWdlIGxvYWRcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuZWFjaChodW1hbml0YXJpYW5TY29wZVZvY2FidWxhcnksIGZ1bmN0aW9uIChpbmRleCwgc2NvcGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICAgICAgdmFyIHZhbCA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShzY29wZSkudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcnO1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVIdW1hbml0YXJpYW5TY29wZUZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShzY29wZSksIHZhbC50b1N0cmluZygpKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgLy8gaGlkZS9zaG93IGZpZWxkcyBvbiB2YWx1ZSBjaGFuZ2VcbiAgICAgICAgICAgIGh1bWFuaXRhcmlhblNjb3BlVm9jYWJ1bGFyeS5vbignc2VsZWN0MjpzZWxlY3QnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciB2YWwgPSBlLnBhcmFtcy5kYXRhLmlkO1xuICAgICAgICAgICAgICAgIHZhciBpbmRleCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVIdW1hbml0YXJpYW5TY29wZUZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShpbmRleCksIHZhbCk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIC8vIGhpZGUvc2hvdyBmaWVsZHMgb24gdmFsdWUgY2xlYXJcbiAgICAgICAgICAgIGh1bWFuaXRhcmlhblNjb3BlVm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIGluZGV4ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZUh1bWFuaXRhcmlhblNjb3BlRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGluZGV4KSwgJycpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8vIGhpZGUgY291bnRyeSBidWRnZXQgYmFzZWQgb24gdm9jYWJ1bGFyeVxuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaGlkZUh1bWFuaXRhcmlhblNjb3BlRmllbGQgPSBmdW5jdGlvbiAoaW5kZXgsIHZhbHVlKSB7XG4gICAgICAgIHZhciBodW1hbml0YXJpYW5TY29wZUhpZGVWb2NhYnVsYXJ5VXJpID0gJ2lucHV0W2lkXj1cImh1bWFuaXRhcmlhbl9zY29wZVwiXVtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdJztcbiAgICAgICAgaWYgKHZhbHVlID09PSAnOTknKSB7XG4gICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgLmZpbmQoaHVtYW5pdGFyaWFuU2NvcGVIaWRlVm9jYWJ1bGFyeVVyaSlcbiAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgIH1cbiAgICAgICAgZWxzZSB7XG4gICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgLmZpbmQoaHVtYW5pdGFyaWFuU2NvcGVIaWRlVm9jYWJ1bGFyeVVyaSlcbiAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogSHVtYW5pdGFyaWFuIFNjb3BlIEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkVXJpID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuICAgICAgICB2YXIgcmVmZXJlbmNlVm9jYWJ1bGFyeSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnc2VsZWN0W2lkXj1cInJlZmVyZW5jZVwiXVtpZCo9XCJbdm9jYWJ1bGFyeV1cIl0nKTtcbiAgICAgICAgaWYgKHJlZmVyZW5jZVZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAgLy8gaGlkZSBmaWVsZHMgb24gcGFnZSBsb2FkXG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2gocmVmZXJlbmNlVm9jYWJ1bGFyeSwgZnVuY3Rpb24gKGluZGV4LCBzY29wZSkge1xuICAgICAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgICAgICB2YXIgdmFsID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHNjb3BlKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJyc7XG4gICAgICAgICAgICAgICAgX3RoaXMuaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShzY29wZSksIHZhbC50b1N0cmluZygpKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgLy8gaGlkZS9zaG93IGZpZWxkcyBvbiB2YWx1ZSBjaGFuZ2VcbiAgICAgICAgICAgIHJlZmVyZW5jZVZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgdmFsID0gZS5wYXJhbXMuZGF0YS5pZDtcbiAgICAgICAgICAgICAgICB2YXIgaW5kZXggPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5pbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGluZGV4KSwgdmFsKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgLy8gaGlkZS9zaG93IGZpZWxkcyBvbiB2YWx1ZSBjbGVhclxuICAgICAgICAgICAgcmVmZXJlbmNlVm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIGluZGV4ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShpbmRleCksICcnKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvLyBoaWRlIGNvdW50cnkgYnVkZ2V0IGJhc2VkIG9uIHZvY2FidWxhcnlcbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmluZGljYXRvclJlZmVyZW5jZUhpZGVGaWVsZCA9IGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcbiAgICAgICAgdmFyIHJlZmVyZW5jZVVyaSA9ICdpbnB1dFtpZF49XCJyZWZlcmVuY2VcIl1baWQqPVwiW2luZGljYXRvcl91cmldXCJdJztcbiAgICAgICAgaWYgKHZhbHVlID09PSAnOTknKSB7XG4gICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgLmZpbmQocmVmZXJlbmNlVXJpKVxuICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgfVxuICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAuZmluZChyZWZlcmVuY2VVcmkpXG4gICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIENvdW50cnkgQnVkZ2V0IEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIHNob3cvaGlkZSAnY29kZScgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuY291bnRyeUJ1ZGdldEhpZGVDb2RlRmllbGQgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgIHZhciBfYTtcbiAgICAgICAgdmFyIGNvdW50cnlCdWRnZXRWb2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3QjY291bnRyeV9idWRnZXRfdm9jYWJ1bGFyeScpO1xuICAgICAgICBpZiAoY291bnRyeUJ1ZGdldFZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAgLy8gaGlkZS9zaG93IG9uIHBhZ2UgbG9hZFxuICAgICAgICAgICAgdmFyIHZhbCA9IChfYSA9IGNvdW50cnlCdWRnZXRWb2NhYnVsYXJ5LnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnMSc7XG4gICAgICAgICAgICB0aGlzLmhpZGVDb3VudHJ5QnVkZ2V0RmllbGQodmFsLnRvU3RyaW5nKCkpO1xuICAgICAgICAgICAgLy8gaGlkZS9zaG93IG9uIHZhbHVlIGNoYW5nZVxuICAgICAgICAgICAgY291bnRyeUJ1ZGdldFZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgdmFsID0gZS5wYXJhbXMuZGF0YS5pZDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlQ291bnRyeUJ1ZGdldEZpZWxkKHZhbCk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIC8vaGlkZS9zaG93IGJhc2VkIG9uIHZhbHVlIGNsZWFyZWRcbiAgICAgICAgICAgIGNvdW50cnlCdWRnZXRWb2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVDb3VudHJ5QnVkZ2V0RmllbGQoJycpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEhpZGUgQ291bnRyeSBCdWRnZXQgRmllbGRzXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5oaWRlQ291bnRyeUJ1ZGdldEZpZWxkID0gZnVuY3Rpb24gKHZhbHVlKSB7XG4gICAgICAgIHZhciBjb3VudHJ5QnVkZ2V0Q29kZUlucHV0ID0gJ2lucHV0W2lkXj1cImJ1ZGdldF9pdGVtXCJdW2lkKj1cIltjb2RlX3RleHRdXCJdJywgY291bnRyeUJ1ZGdldENvZGVTZWxlY3QgPSAnc2VsZWN0W2lkXj1cImJ1ZGdldF9pdGVtXCJdW2lkKj1cIltjb2RlXVwiXSc7XG4gICAgICAgIGlmICh2YWx1ZSA9PT0gJzEnKSB7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoY291bnRyeUJ1ZGdldENvZGVTZWxlY3QpXG4gICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShjb3VudHJ5QnVkZ2V0Q29kZUlucHV0KVxuICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICB9XG4gICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGNvdW50cnlCdWRnZXRDb2RlU2VsZWN0KVxuICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGNvdW50cnlCdWRnZXRDb2RlSW5wdXQpXG4gICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEFpZFR5cGUgRm9ybSBQYWdlXG4gICAgICpcbiAgICAgKiBATG9naWMgaGlkZSB2b2NhYnVsYXJ5LXVyaSBhbmQgY29kZXMgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuYWlkVHlwZVZvY2FidWxhcnlIaWRlRmllbGQgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgIHZhciBhaWR0eXBlX3ZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdFtpZCo9XCJkZWZhdWx0X2FpZF90eXBlX3ZvY2FidWxhcnlcIl0nKTtcbiAgICAgICAgaWYgKGFpZHR5cGVfdm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2goYWlkdHlwZV92b2NhYnVsYXJ5LCBmdW5jdGlvbiAoaW5kZXgsIGl0ZW0pIHtcbiAgICAgICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSAoX2EgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaXRlbSkudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcxJztcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlQWlkVHlwZVNlbGVjdEZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShpdGVtKSwgZGF0YS50b1N0cmluZygpKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgYWlkdHlwZV92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOnNlbGVjdCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSBlLnBhcmFtcy5kYXRhLmlkO1xuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlQWlkVHlwZVNlbGVjdEZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCBkYXRhKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgYWlkdHlwZV92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZUFpZFR5cGVTZWxlY3RGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgJycpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEFpZFR5cGUgRm9ybSBQYWdlXG4gICAgICpcbiAgICAgKiBATG9naWMgaGlkZSB2b2NhYnVsYXJ5LXVyaSBhbmQgY29kZXMgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUudHJhbnNhY3Rpb25BaWRUeXBlVm9jYWJ1bGFyeUhpZGVGaWVsZCA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgdmFyIGFpZHR5cGVfdm9jYWJ1bGFyeSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnc2VsZWN0W2lkKj1cImFpZF90eXBlX3ZvY2FidWxhcnlcIl0nKTtcbiAgICAgICAgaWYgKGFpZHR5cGVfdm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2goYWlkdHlwZV92b2NhYnVsYXJ5LCBmdW5jdGlvbiAoaW5kZXgsIGl0ZW0pIHtcbiAgICAgICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSAoX2EgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaXRlbSkudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcxJztcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlVHJhbnNhY3Rpb25BaWRUeXBlU2VsZWN0RmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGl0ZW0pLCBkYXRhLnRvU3RyaW5nKCkpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICBhaWR0eXBlX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IGUucGFyYW1zLmRhdGEuaWQ7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVUcmFuc2FjdGlvbkFpZFR5cGVTZWxlY3RGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgZGF0YSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIGFpZHR5cGVfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVUcmFuc2FjdGlvbkFpZFR5cGVTZWxlY3RGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgJycpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEhpZGUgQWlkIFR5cGUgU2VsZWN0IEZpZWxkc1xuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaGlkZUFpZFR5cGVTZWxlY3RGaWVsZCA9IGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcbiAgICAgICAgdmFyIGRlZmF1bHRfYWlkX3R5cGUgPSAnc2VsZWN0W2lkKj1cIltkZWZhdWx0X2FpZF90eXBlXVwiXScsIGVhcm1hcmtpbmdfY2F0ZWdvcnkgPSAnc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX2NhdGVnb3J5XVwiXScsIGVhcm1hcmtpbmdfbW9kYWxpdHkgPSAnc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX21vZGFsaXR5XVwiXScsIGNhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllcyA9ICdzZWxlY3RbaWQqPVwiW2Nhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllc11cIl0nLCBjYXNlMSA9ICdzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfY2F0ZWdvcnldXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19tb2RhbGl0eV1cIl0sc2VsZWN0W2lkKj1cIltjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXNdXCJdJywgY2FzZTIgPSAnc2VsZWN0W2lkKj1cIltkZWZhdWx0X2FpZF90eXBlXVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfbW9kYWxpdHldXCJdLHNlbGVjdFtpZCo9XCJbY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzXVwiXScsIGNhc2UzID0gJ3NlbGVjdFtpZCo9XCJbZGVmYXVsdF9haWRfdHlwZV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX2NhdGVnb3J5XVwiXSxzZWxlY3RbaWQqPVwiW2Nhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllc11cIl0nLCBjYXNlNCA9ICdzZWxlY3RbaWQqPVwiW2RlZmF1bHRfYWlkX3R5cGVdXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19jYXRlZ29yeV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX21vZGFsaXR5XVwiXSc7XG4gICAgICAgIHN3aXRjaCAodmFsdWUpIHtcbiAgICAgICAgICAgIGNhc2UgJzInOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGVhcm1hcmtpbmdfY2F0ZWdvcnkpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMilcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzMnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGVhcm1hcmtpbmdfbW9kYWxpdHkpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMylcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzQnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllcylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U0KVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgZGVmYXVsdDpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChkZWZhdWx0X2FpZF90eXBlKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTEpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEhpZGUgVHJhbnNhY3Rpb24gQWlkIFR5cGUgU2VsZWN0IEZpZWxkc1xuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaGlkZVRyYW5zYWN0aW9uQWlkVHlwZVNlbGVjdEZpZWxkID0gZnVuY3Rpb24gKGluZGV4LCB2YWx1ZSkge1xuICAgICAgICB2YXIgYWlkX3R5cGUgPSAnc2VsZWN0W2lkKj1cIlthaWRfdHlwZV9jb2RlXVwiXScsIGVhcm1hcmtpbmdfY2F0ZWdvcnkgPSAnc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX2NhdGVnb3J5XVwiXScsIGVhcm1hcmtpbmdfbW9kYWxpdHkgPSAnc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX21vZGFsaXR5XVwiXScsIGNhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllcyA9ICdzZWxlY3RbaWQqPVwiW2Nhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllc11cIl0nLCBjYXNlMSA9ICdzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfY2F0ZWdvcnldXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19tb2RhbGl0eV1cIl0sc2VsZWN0W2lkKj1cIltjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXNdXCJdJywgY2FzZTIgPSAnc2VsZWN0W2lkKj1cIlthaWRfdHlwZV9jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfbW9kYWxpdHldXCJdLHNlbGVjdFtpZCo9XCJbY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzXVwiXScsIGNhc2UzID0gJ3NlbGVjdFtpZCo9XCJbYWlkX3R5cGVfY29kZV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX2NhdGVnb3J5XVwiXSxzZWxlY3RbaWQqPVwiW2Nhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllc11cIl0nLCBjYXNlNCA9ICdzZWxlY3RbaWQqPVwiW2FpZF90eXBlX2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19jYXRlZ29yeV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX21vZGFsaXR5XVwiXSc7XG4gICAgICAgIHN3aXRjaCAodmFsdWUpIHtcbiAgICAgICAgICAgIGNhc2UgJzInOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGVhcm1hcmtpbmdfY2F0ZWdvcnkpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMilcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzMnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGVhcm1hcmtpbmdfbW9kYWxpdHkpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMylcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzQnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllcylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U0KVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgZGVmYXVsdDpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChhaWRfdHlwZSlcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBQb2xpY3kgTWFya2VyIEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgYW5kIGNvZGVzIGZpZWxkIGJhc2VkIG9uICdAdm9jYWJ1bGFyeScgZmllbGQgdmFsdWVcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLnBvbGljeVZvY2FidWxhcnlIaWRlRmllbGQgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgIHZhciBwb2xpY3ltYWtlcl92b2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3RbaWQqPVwicG9saWN5X21hcmtlcl92b2NhYnVsYXJ5XCJdJyk7XG4gICAgICAgIGlmIChwb2xpY3ltYWtlcl92b2NhYnVsYXJ5Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuZWFjaChwb2xpY3ltYWtlcl92b2NhYnVsYXJ5LCBmdW5jdGlvbiAoaW5kZXgsIHBvbGljeV9tYXJrZXIpIHtcbiAgICAgICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSAoX2EgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkocG9saWN5X21hcmtlcikudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcxJztcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlUG9saWN5TWFrZXJGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkocG9saWN5X21hcmtlciksIGRhdGEudG9TdHJpbmcoKSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIHBvbGljeW1ha2VyX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IGUucGFyYW1zLmRhdGEuaWQ7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVQb2xpY3lNYWtlckZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCBkYXRhKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgcG9saWN5bWFrZXJfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVQb2xpY3lNYWtlckZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCAnOTknKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBIaWRlcyBQb2xpY3kgTWFya2VyIEZvcm0gRmllbGRzXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5oaWRlUG9saWN5TWFrZXJGaWVsZCA9IGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcbiAgICAgICAgdmFyIGNhc2UxX3Nob3cgPSAnc2VsZWN0W2lkKj1cIltwb2xpY3lfbWFya2VyXVwiXScsIGNhc2UyX3Nob3cgPSAnaW5wdXRbaWQqPVwiW3BvbGljeV9tYXJrZXJfdGV4dF1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXScsIGNhc2UxID0gJ2lucHV0W2lkKj1cIltwb2xpY3lfbWFya2VyX3RleHRdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0nLCBjYXNlMiA9ICdzZWxlY3RbaWQqPVwiW3BvbGljeV9tYXJrZXJdXCJdJztcbiAgICAgICAgc3dpdGNoICh2YWx1ZSkge1xuICAgICAgICAgICAgY2FzZSAnMSc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTFfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnOTknOlxuICAgICAgICAgICAgZGVmYXVsdDpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMl9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTIpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIFNlY3RvciBGb3JtIFBhZ2VcbiAgICAgKlxuICAgICAqIEBMb2dpYyBoaWRlIHZvY2FidWxhcnktdXJpIGFuZCBjb2RlcyBmaWVsZCBiYXNlZCBvbiAnQHZvY2FidWxhcnknIGZpZWxkIHZhbHVlXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5zZWN0b3JWb2NhYnVsYXJ5SGlkZUZpZWxkID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuICAgICAgICB2YXIgc2VjdG9yX3ZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdFtpZCo9XCJzZWN0b3Jfdm9jYWJ1bGFyeVwiXScpO1xuICAgICAgICBpZiAoc2VjdG9yX3ZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAganF1ZXJ5XzEuZGVmYXVsdC5lYWNoKHNlY3Rvcl92b2NhYnVsYXJ5LCBmdW5jdGlvbiAoaW5kZXgsIHNlY3Rvcikge1xuICAgICAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShzZWN0b3IpLnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnMSc7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVNlY3RvckZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShzZWN0b3IpLCBkYXRhLnRvU3RyaW5nKCkpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICBzZWN0b3Jfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpzZWxlY3QnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gZS5wYXJhbXMuZGF0YS5pZDtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVNlY3RvckZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCBkYXRhKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgc2VjdG9yX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6Y2xlYXInLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlU2VjdG9yRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksICcnKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBIaWRlIFNlY3RvciBGb3JtIGZpZWxkc1xuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaGlkZVNlY3RvckZpZWxkID0gZnVuY3Rpb24gKGluZGV4LCB2YWx1ZSkge1xuICAgICAgICB2YXIgY2FzZTFfc2hvdyA9ICdzZWxlY3RbaWQqPVwiW2NvZGVdXCJdJywgY2FzZTJfc2hvdyA9ICdzZWxlY3RbaWQqPVwiW2NhdGVnb3J5X2NvZGVdXCJdJywgY2FzZTdfc2hvdyA9ICdzZWxlY3RbaWQqPVwiW3NkZ19nb2FsXVwiXScsIGNhc2U4X3Nob3cgPSAnc2VsZWN0W2lkKj1cIltzZGdfdGFyZ2V0XVwiXScsIGNhc2U5OF85OV9zaG93ID0gJ2lucHV0W2lkKj1cIlt0ZXh0XVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdJywgZGVmYXVsdF9zaG93ID0gJ2lucHV0W2lkKj1cIlt0ZXh0XVwiXScsIGNhc2UxID0gJ3NlbGVjdFtpZCo9XCJbY2F0ZWdvcnlfY29kZV1cIl0sc2VsZWN0W2lkKj1cIltzZGdfZ29hbF1cIl0sc2VsZWN0W2lkKj1cIltzZGdfdGFyZ2V0XVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdLGlucHV0W2lkKj1cIlt0ZXh0XVwiXScsIGNhc2UyID0gJ2lucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0sc2VsZWN0W2lkKj1cIltzZGdfZ29hbF1cIl0sc2VsZWN0W2lkKj1cIltzZGdfdGFyZ2V0XVwiXSxzZWxlY3RbaWQqPVwiW2NvZGVdXCJdLGlucHV0W2lkKj1cIlt0ZXh0XVwiXScsIGNhc2U3ID0gJ2lucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0sc2VsZWN0W2lkKj1cIltjYXRlZ29yeV9jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ190YXJnZXRdXCJdLHNlbGVjdFtpZCo9XCJbY29kZV1cIl0saW5wdXRbaWQqPVwiW3RleHRdXCJdJywgY2FzZTggPSAnaW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSxzZWxlY3RbaWQqPVwiW2NhdGVnb3J5X2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX2dvYWxdXCJdLHNlbGVjdFtpZCo9XCJbY29kZV1cIl0saW5wdXRbaWQqPVwiW3RleHRdXCJdJywgY2FzZTk4Xzk5ID0gJ3NlbGVjdFtpZCo9XCJbY2F0ZWdvcnlfY29kZV1cIl0sc2VsZWN0W2lkKj1cIltzZGdfZ29hbF1cIl0sc2VsZWN0W2lkKj1cIltzZGdfdGFyZ2V0XVwiXSxzZWxlY3RbaWQqPVwiW2NvZGVdXCJdJywgZGVmYXVsdF9oaWRlID0gJ3NlbGVjdFtpZCo9XCJbY2F0ZWdvcnlfY29kZV1cIl0sc2VsZWN0W2lkKj1cIltzZGdfZ29hbF1cIl0sc2VsZWN0W2lkKj1cIltzZGdfdGFyZ2V0XVwiXSxzZWxlY3RbaWQqPVwiW2NvZGVdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0nO1xuICAgICAgICBzd2l0Y2ggKHZhbHVlKSB7XG4gICAgICAgICAgICBjYXNlICcxJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMV9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTEpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICcyJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMl9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTIpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICc3JzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlN19zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTcpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICc4JzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOF9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTgpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICc5OCc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTk4Xzk5X3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOThfOTkpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICc5OSc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTk4Xzk5X3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOThfOTkpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBkZWZhdWx0OlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGRlZmF1bHRfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGRlZmF1bHRfaGlkZSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogIFJlY2lwaWVudCBWb2NhYnVsYXJ5IEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgYW5kIGNvZGVzIGZpZWxkIGJhc2VkIG9uICdAdm9jYWJ1bGFyeScgZmllbGQgdmFsdWVcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLnJlY2lwaWVudFZvY2FidWxhcnlIaWRlRmllbGQgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgIHZhciByZWdpb25fdm9jYWJ1bGFyeSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnc2VsZWN0W2lkKj1cInJlZ2lvbl92b2NhYnVsYXJ5XCJdJyk7XG4gICAgICAgIGlmIChyZWdpb25fdm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2gocmVnaW9uX3ZvY2FidWxhcnksIGZ1bmN0aW9uIChpbmRleCwgcmVnaW9uX3ZvY2FiKSB7XG4gICAgICAgICAgICAgICAgdmFyIF9hO1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHJlZ2lvbl92b2NhYikudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcxJztcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlUmVjaXBpZW50UmVnaW9uRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHJlZ2lvbl92b2NhYiksIGRhdGEudG9TdHJpbmcoKSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIHJlZ2lvbl92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOnNlbGVjdCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSBlLnBhcmFtcy5kYXRhLmlkO1xuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlUmVjaXBpZW50UmVnaW9uRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksIGRhdGEpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICByZWdpb25fdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVSZWNpcGllbnRSZWdpb25GaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgJycpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEhpZGVzIFJlY2lwaWVudCBSZWdpb24gRm9ybSBGaWVsZHNcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmhpZGVSZWNpcGllbnRSZWdpb25GaWVsZCA9IGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcbiAgICAgICAgdmFyIGNhc2UxX3Nob3cgPSAnc2VsZWN0W2lkKj1cIltyZWdpb25fY29kZV1cIl0nLCBjYXNlMl9zaG93ID0gJ2lucHV0W2lkKj1cIltjdXN0b21fY29kZV1cIl0sIGlucHV0W2lkKj1cIltjb2RlXVwiXScsIGNhc2U5OV9zaG93ID0gJ2lucHV0W2lkKj1cIltjdXN0b21fY29kZV1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSwgaW5wdXRbaWQqPVwiW2NvZGVdXCJdJywgY2FzZTEgPSAnaW5wdXRbaWQqPVwiW2N1c3RvbV9jb2RlXVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdLGlucHV0W2lkKj1cIltjb2RlXVwiXScsIGNhc2UyID0gJ3NlbGVjdFtpZCo9XCJbcmVnaW9uX2NvZGVdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0nLCBjYXNlOTkgPSAnc2VsZWN0W2lkKj1cIltyZWdpb25fY29kZV1cIl0nO1xuICAgICAgICBzd2l0Y2ggKHZhbHVlKSB7XG4gICAgICAgICAgICBjYXNlICcxJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMV9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTEpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICcyJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMl9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTIpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICc5OSc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTk5X3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOTkpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBkZWZhdWx0OlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMilcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogVXBkYXRlcyBBY3Rpdml0eSBpZGVudGlmaWVyXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS51cGRhdGVBY3Rpdml0eUlkZW50aWZpZXIgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBhY3Rpdml0eV9pZGVudGlmaWVyID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjYWN0aXZpdHlfaWRlbnRpZmllcicpO1xuICAgICAgICBpZiAoYWN0aXZpdHlfaWRlbnRpZmllci5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBhY3Rpdml0eV9pZGVudGlmaWVyLm9uKCdrZXl1cCcsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNpYXRpX2lkZW50aWZpZXJfdGV4dCcpLnZhbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5pZGVudGlmaWVyJykuYXR0cignYWN0aXZpdHlfaWRlbnRpZmllcicpICsgXCItXCIuY29uY2F0KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS52YWwoKSkpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIFRhZyBGb3JtIFBhZ2VcbiAgICAgKlxuICAgICAqIEBMb2dpYyBoaWRlIHZvY2FidWxhcnktdXJpIGFuZCBjb2RlcyBmaWVsZCBiYXNlZCBvbiAnQHZvY2FidWxhcnknIGZpZWxkIHZhbHVlXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS50YWdWb2NhYnVsYXJ5SGlkZUZpZWxkID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuICAgICAgICB2YXIgdGFnX3ZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdFtpZCo9XCJ0YWdfdm9jYWJ1bGFyeVwiXScpO1xuICAgICAgICBpZiAodGFnX3ZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAganF1ZXJ5XzEuZGVmYXVsdC5lYWNoKHRhZ192b2NhYnVsYXJ5LCBmdW5jdGlvbiAoaW5kZXgsIHRhZykge1xuICAgICAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YWcpLnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnMSc7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVRhZ0ZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YWcpLCBkYXRhLnRvU3RyaW5nKCkpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICB0YWdfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpzZWxlY3QnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gZS5wYXJhbXMuZGF0YS5pZDtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVRhZ0ZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCBkYXRhKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgdGFnX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6Y2xlYXInLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlVGFnRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksICcnKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBIaWRlIFRhZyBGb3JtIGZpZWxkc1xuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaGlkZVRhZ0ZpZWxkID0gZnVuY3Rpb24gKGluZGV4LCB2YWx1ZSkge1xuICAgICAgICB2YXIgY2FzZTFfc2hvdyA9ICdpbnB1dFtpZCo9XCJbdGFnX3RleHRdXCJdJywgY2FzZTJfc2hvdyA9ICdzZWxlY3RbaWQqPVwiW2dvYWxzX3RhZ19jb2RlXVwiXScsIGNhc2UzX3Nob3cgPSAnc2VsZWN0W2lkKj1cIlt0YXJnZXRzX3RhZ19jb2RlXVwiXScsIGNhc2U5OV9zaG93ID0gJ2lucHV0W2lkKj1cIlt0YWdfdGV4dF1cIl0sIGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0nLCBjYXNlMSA9ICdzZWxlY3RbaWQqPVwiW2dvYWxzX3RhZ19jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW3RhcmdldHNfdGFnX2NvZGVdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0nLCBjYXNlMiA9ICdpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdLHNlbGVjdFtpZCo9XCJbdGFyZ2V0c190YWdfY29kZV1cIl0sc2VsZWN0W2lkKj1cIlt0YXJnZXRzX3RhZ19jb2RlXVwiXSxpbnB1dFtpZCo9XCJbdGFnX3RleHRdXCJdJywgY2FzZTMgPSAnaW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSxzZWxlY3RbaWQqPVwiW2dvYWxzX3RhZ19jb2RlXVwiXSxpbnB1dFtpZCo9XCJbdGFnX3RleHRdXCJdJywgY2FzZTk5ID0gJ3NlbGVjdFtpZCo9XCJbZ29hbHNfdGFnX2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbdGFyZ2V0c190YWdfY29kZV1cIl0nO1xuICAgICAgICBzd2l0Y2ggKHZhbHVlKSB7XG4gICAgICAgICAgICBjYXNlICcxJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMV9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTEpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICcyJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMl9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTIpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICczJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlM19zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTMpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICc5OSc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTk5X3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOTkpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBkZWZhdWx0OlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgcmV0dXJuIER5bmFtaWNGaWVsZDtcbn0oKSk7XG5leHBvcnRzLkR5bmFtaWNGaWVsZCA9IER5bmFtaWNGaWVsZDtcbiIsIlwidXNlIHN0cmljdFwiO1xudmFyIF9faW1wb3J0RGVmYXVsdCA9ICh0aGlzICYmIHRoaXMuX19pbXBvcnREZWZhdWx0KSB8fCBmdW5jdGlvbiAobW9kKSB7XG4gICAgcmV0dXJuIChtb2QgJiYgbW9kLl9fZXNNb2R1bGUpID8gbW9kIDogeyBcImRlZmF1bHRcIjogbW9kIH07XG59O1xuT2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFwiX19lc01vZHVsZVwiLCB7IHZhbHVlOiB0cnVlIH0pO1xudmFyIGF4aW9zXzEgPSBfX2ltcG9ydERlZmF1bHQocmVxdWlyZShcImF4aW9zXCIpKTtcbnZhciBqcXVlcnlfMSA9IF9faW1wb3J0RGVmYXVsdChyZXF1aXJlKFwianF1ZXJ5XCIpKTtcbnJlcXVpcmUoXCJzZWxlY3QyXCIpO1xudmFyIER5bmFtaWNGaWVsZF8xID0gcmVxdWlyZShcIi4vRHluYW1pY0ZpZWxkXCIpO1xudmFyIGR5bmFtaWNGaWVsZCA9IG5ldyBEeW5hbWljRmllbGRfMS5EeW5hbWljRmllbGQoKTtcbnZhciBGb3JtQnVpbGRlciA9IC8qKiBAY2xhc3MgKi8gKGZ1bmN0aW9uICgpIHtcbiAgICBmdW5jdGlvbiBGb3JtQnVpbGRlcigpIHtcbiAgICB9XG4gICAgLy8gYWRkcyBuZXcgY29sbGVjdGlvbiBvZiBzdWItZWxlbWVudFxuICAgIEZvcm1CdWlsZGVyLnByb3RvdHlwZS5hZGRGb3JtID0gZnVuY3Rpb24gKGV2KSB7XG4gICAgICAgIGV2LnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIHZhciB0YXJnZXQgPSBldi50YXJnZXQ7XG4gICAgICAgIHZhciBjb250YWluZXIgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdmb3JtX3R5cGUnKVxuICAgICAgICAgICAgPyAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoXCIuY29sbGVjdGlvbi1jb250YWluZXJbZm9ybV90eXBlID0nXCIuY29uY2F0KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2Zvcm1fdHlwZScpLCBcIiddXCIpKVxuICAgICAgICAgICAgOiAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5jb2xsZWN0aW9uLWNvbnRhaW5lcicpO1xuICAgICAgICB2YXIgY291bnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdjaGlsZF9jb3VudCcpXG4gICAgICAgICAgICA/IHBhcnNlSW50KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2NoaWxkX2NvdW50JykpICsgMVxuICAgICAgICAgICAgOiAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wYXJlbnQoKS5maW5kKCcuZm9ybS1jaGlsZC1ib2R5JykubGVuZ3RoO1xuICAgICAgICB2YXIgcGFyZW50X2NvdW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cigncGFyZW50X2NvdW50JylcbiAgICAgICAgICAgID8gcGFyc2VJbnQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cigncGFyZW50X2NvdW50JykpXG4gICAgICAgICAgICA6ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLnBhcmVudHMoJy5tdWx0aS1mb3JtJykuaW5kZXgoKSAtIDE7XG4gICAgICAgIHZhciB3cmFwcGVyX3BhcmVudF9jb3VudCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ3dyYXBwZWRfcGFyZW50X2NvdW50JylcbiAgICAgICAgICAgID8gcGFyc2VJbnQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignd3JhcHBlZF9wYXJlbnRfY291bnQnKSlcbiAgICAgICAgICAgIDogKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucGFyZW50cygnLndyYXBwZWQtY2hpbGQtYm9keScpLmluZGV4KCkgLSAxO1xuICAgICAgICB2YXIgcHJvdG8gPSBjb250YWluZXJcbiAgICAgICAgICAgIC5kYXRhKCdwcm90b3R5cGUnKVxuICAgICAgICAgICAgLnJlcGxhY2UoL19fUEFSRU5UX05BTUVfXy9nLCBwYXJlbnRfY291bnQpO1xuICAgICAgICBpZiAoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignaGFzX2NoaWxkX2NvbGxlY3Rpb24nKSkge1xuICAgICAgICAgICAgcHJvdG8gPSBwcm90by5yZXBsYWNlKC9fX1dSQVBQRVJfTkFNRV9fL2csIGNvdW50KTtcbiAgICAgICAgICAgIHByb3RvID0gcHJvdG8ucmVwbGFjZSgvX19OQU1FX18vZywgMCk7XG4gICAgICAgIH1cbiAgICAgICAgZWxzZSB7XG4gICAgICAgICAgICBwcm90byA9IHByb3RvLnJlcGxhY2UoL19fTkFNRV9fL2csIGNvdW50KTtcbiAgICAgICAgICAgIHByb3RvID0gcHJvdG8ucmVwbGFjZSgvX19XUkFQUEVSX05BTUVfXy9nLCB3cmFwcGVyX3BhcmVudF9jb3VudCk7XG4gICAgICAgIH1cbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucHJldigpLmFwcGVuZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkocHJvdG8pKTtcbiAgICAgICAgaWYgKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2hhc19jaGlsZF9jb2xsZWN0aW9uJykpIHtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXG4gICAgICAgICAgICAgICAgLnByZXYoJy5zdWJlbGVtZW50JylcbiAgICAgICAgICAgICAgICAuY2hpbGRyZW4oJy53cmFwcGVkLWNoaWxkLWJvZHknKVxuICAgICAgICAgICAgICAgIC5sYXN0KClcbiAgICAgICAgICAgICAgICAuZmluZCgnLmFkZF90b19jb2xsZWN0aW9uJylcbiAgICAgICAgICAgICAgICAuYXR0cignd3JhcHBlZF9wYXJlbnRfY291bnQnLCBjb3VudCk7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KVxuICAgICAgICAgICAgICAgIC5wcmV2KCcuc3ViZWxlbWVudCcpXG4gICAgICAgICAgICAgICAgLmNoaWxkcmVuKCcud3JhcHBlZC1jaGlsZC1ib2R5JylcbiAgICAgICAgICAgICAgICAubGFzdCgpXG4gICAgICAgICAgICAgICAgLmZpbmQoJy5hZGRfdG9fY29sbGVjdGlvbicpXG4gICAgICAgICAgICAgICAgLmF0dHIoJ3BhcmVudF9jb3VudCcsIHBhcmVudF9jb3VudCk7XG4gICAgICAgIH1cbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldClcbiAgICAgICAgICAgIC5wcmV2KClcbiAgICAgICAgICAgIC5maW5kKCcud3JhcHBlZC1jaGlsZC1ib2R5JylcbiAgICAgICAgICAgIC5sYXN0KClcbiAgICAgICAgICAgIC5maW5kKCcuYWRkX3RvX2NvbGxlY3Rpb24nKVxuICAgICAgICAgICAgLmF0dHIoJ3dyYXBwZXJfcGFyZW50X2NvdW50Jywgd3JhcHBlcl9wYXJlbnRfY291bnQgIT09IG51bGwgJiYgd3JhcHBlcl9wYXJlbnRfY291bnQgIT09IHZvaWQgMCA/IHdyYXBwZXJfcGFyZW50X2NvdW50IDogMCk7XG4gICAgICAgIGlmICgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdmb3JtX3R5cGUnKSkge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucHJldigpLmxhc3QoKS5maW5kKCcuc2VsZWN0MicpLnNlbGVjdDIoe1xuICAgICAgICAgICAgICAgIHBsYWNlaG9sZGVyOiAnU2VsZWN0IGFuIG9wdGlvbicsXG4gICAgICAgICAgICAgICAgYWxsb3dDbGVhcjogdHJ1ZSxcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpXG4gICAgICAgICAgICAgICAgLmZpbmQoJy5zdWItYXR0cmlidXRlJylcbiAgICAgICAgICAgICAgICAud3JhcEFsbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJzxkaXYgY2xhc3M9XCJmb3JtLWZpZWxkLWdyb3VwIGZsZXggZmxleC13cmFwIHJvdW5kZWQtYnItbGcgYm9yZGVyLXkgYm9yZGVyLXIgYm9yZGVyLXNwcmluZy01MCBzdWItYXR0cmlidXRlLXdyYXBwZXJcIj48L2Rpdj4nKSk7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KVxuICAgICAgICAgICAgICAgIC5wcmV2KCcuc3ViZWxlbWVudCcpXG4gICAgICAgICAgICAgICAgLmNoaWxkcmVuKCcud3JhcHBlZC1jaGlsZC1ib2R5JylcbiAgICAgICAgICAgICAgICAubGFzdCgpXG4gICAgICAgICAgICAgICAgLmZpbmQoJy5zdWItYXR0cmlidXRlJylcbiAgICAgICAgICAgICAgICAud3JhcEFsbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJzxkaXYgY2xhc3M9XCJmb3JtLWZpZWxkLWdyb3VwIGZsZXggZmxleC13cmFwIHJvdW5kZWQtYnItbGcgYm9yZGVyLXkgYm9yZGVyLXIgYm9yZGVyLXNwcmluZy01MCBzdWItYXR0cmlidXRlLXdyYXBwZXIgbXQtNlwiPjwvZGl2PicpKTtcbiAgICAgICAgfVxuICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXG4gICAgICAgICAgICAgICAgLnBhcmVudCgpXG4gICAgICAgICAgICAgICAgLmZpbmQoJy5mb3JtLWNoaWxkLWJvZHknKVxuICAgICAgICAgICAgICAgIC5sYXN0KClcbiAgICAgICAgICAgICAgICAuZmluZCgnLnNlbGVjdDInKVxuICAgICAgICAgICAgICAgIC5zZWxlY3QyKHtcbiAgICAgICAgICAgICAgICBwbGFjZWhvbGRlcjogJ1NlbGVjdCBhbiBvcHRpb24nLFxuICAgICAgICAgICAgICAgIGFsbG93Q2xlYXI6IHRydWUsXG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdjaGlsZF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgZHluYW1pY0ZpZWxkLmFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC5zZWN0b3JWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgfTtcbiAgICAvLyBhZGRzIHBhcmVudCBjb2xsZWN0aW9uXG4gICAgRm9ybUJ1aWxkZXIucHJvdG90eXBlLmFkZFBhcmVudEZvcm0gPSBmdW5jdGlvbiAoZXYpIHtcbiAgICAgICAgZXYucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgdmFyIHRhcmdldCA9IGV2LnRhcmdldDtcbiAgICAgICAgdmFyIGNvbnRhaW5lciA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2Zvcm1fdHlwZScpXG4gICAgICAgICAgICA/ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShcIi5wYXJlbnQtY29sbGVjdGlvbltmb3JtX3R5cGUgPSdcIi5jb25jYXQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignZm9ybV90eXBlJyksIFwiJ11cIikpXG4gICAgICAgICAgICA6ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLnBhcmVudC1jb2xsZWN0aW9uJyk7XG4gICAgICAgIHZhciBjb3VudCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ3BhcmVudF9jb3VudCcpXG4gICAgICAgICAgICA/IHBhcnNlSW50KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ3BhcmVudF9jb3VudCcpKSArIDFcbiAgICAgICAgICAgIDogKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLnByZXYoKS5maW5kKCcubXVsdGktZm9ybScpLmxlbmd0aFxuICAgICAgICAgICAgICAgID8gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucHJldigpLmZpbmQoJy5tdWx0aS1mb3JtJykubGVuZ3RoXG4gICAgICAgICAgICAgICAgOiAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wcmV2KCkuZmluZCgnLndyYXBwZWQtY2hpbGQtYm9keScpLmxlbmd0aCkgKyAxO1xuICAgICAgICB2YXIgcHJvdG8gPSBjb250YWluZXIuZGF0YSgncHJvdG90eXBlJykucmVwbGFjZSgvX19QQVJFTlRfTkFNRV9fL2csIGNvdW50KTtcbiAgICAgICAgcHJvdG8gPSBwcm90by5yZXBsYWNlKC9fX05BTUVfXy9nLCAwKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucHJldigpLmFwcGVuZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkocHJvdG8pKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucHJldigpLmZpbmQoJy5tdWx0aS1mb3JtJykubGFzdCgpLmZpbmQoJy5zZWxlY3QyJykuc2VsZWN0Mih7XG4gICAgICAgICAgICBwbGFjZWhvbGRlcjogJ1NlbGVjdCBhbiBvcHRpb24nLFxuICAgICAgICAgICAgYWxsb3dDbGVhcjogdHJ1ZSxcbiAgICAgICAgfSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXG4gICAgICAgICAgICAucHJldigpXG4gICAgICAgICAgICAuZmluZCgnLm11bHRpLWZvcm0nKVxuICAgICAgICAgICAgLmxhc3QoKVxuICAgICAgICAgICAgLmZpbmQoJy5hZGRfdG9fY29sbGVjdGlvbicpXG4gICAgICAgICAgICAuYXR0cigncGFyZW50X2NvdW50JywgY291bnQpO1xuICAgICAgICB0aGlzLmFkZFdyYXBwZXJPbkFkZCh0YXJnZXQpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdwYXJlbnRfY291bnQnLCBjb3VudCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC5odW1hbml0YXJpYW5TY29wZUhpZGVWb2NhYnVsYXJ5VXJpKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC5jb3VudHJ5QnVkZ2V0SGlkZUNvZGVGaWVsZCgpO1xuICAgICAgICBkeW5hbWljRmllbGQuc2VjdG9yVm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICBkeW5hbWljRmllbGQucmVjaXBpZW50Vm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICBkeW5hbWljRmllbGQucG9saWN5Vm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICBkeW5hbWljRmllbGQudGFnVm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICBkeW5hbWljRmllbGQudHJhbnNhY3Rpb25BaWRUeXBlVm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICBkeW5hbWljRmllbGQuaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkVXJpKCk7XG4gICAgfTtcbiAgICAvLyBkZWxldGVzIGNvbGxlY3Rpb25cbiAgICBGb3JtQnVpbGRlci5wcm90b3R5cGUuZGVsZXRlRm9ybSA9IGZ1bmN0aW9uIChldikge1xuICAgICAgICBldi5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICB2YXIgdGFyZ2V0ID0gZXYudGFyZ2V0O1xuICAgICAgICB2YXIgY29sbGVjdGlvbkxlbmd0aCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLm11bHRpLWZvcm0nKS5sZW5ndGhcbiAgICAgICAgICAgID8gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuY2xvc2VzdCgnLnN1YmVsZW1lbnQnKS5maW5kKCcuZm9ybS1jaGlsZC1ib2R5JykubGVuZ3RoXG4gICAgICAgICAgICA6ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmZvcm0tY2hpbGQtYm9keScpLmxlbmd0aDtcbiAgICAgICAgdmFyIGNvdW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX2NvbGxlY3Rpb24nKS5hdHRyKCdjaGlsZF9jb3VudCcpXG4gICAgICAgICAgICA/IHBhcnNlSW50KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmFkZF90b19jb2xsZWN0aW9uJykuYXR0cignY2hpbGRfY291bnQnKSkgKyAxXG4gICAgICAgICAgICA6IGNvbGxlY3Rpb25MZW5ndGg7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmFkZF90b19jb2xsZWN0aW9uJykuYXR0cignY2hpbGRfY291bnQnLCBjb3VudCk7XG4gICAgICAgIGlmIChjb2xsZWN0aW9uTGVuZ3RoID4gMSkge1xuICAgICAgICAgICAgdmFyIHRnID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuY2xvc2VzdCgnLmZvcm0tY2hpbGQtYm9keScpO1xuICAgICAgICAgICAgdGcubmV4dCgnLmVycm9yJykucmVtb3ZlKCk7XG4gICAgICAgICAgICB0Zy5yZW1vdmUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLy8gZGVsZXRlcyBwYXJlbnQgY29sbGVjdGlvblxuICAgIEZvcm1CdWlsZGVyLnByb3RvdHlwZS5kZWxldGVQYXJlbnRGb3JtID0gZnVuY3Rpb24gKGV2KSB7XG4gICAgICAgIGV2LnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIHZhciB0YXJnZXQgPSBldi50YXJnZXQ7XG4gICAgICAgIHZhciBjb2xsZWN0aW9uTGVuZ3RoID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuc3ViZWxlbWVudCcpLmxlbmd0aDtcbiAgICAgICAgdmFyIGNvdW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX3BhcmVudCcpLmF0dHIoJ2NoaWxkX2NvdW50JylcbiAgICAgICAgICAgID8gcGFyc2VJbnQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX3BhcmVudCcpLmF0dHIoJ2NoaWxkX2NvdW50JykpICsgMVxuICAgICAgICAgICAgOiBjb2xsZWN0aW9uTGVuZ3RoO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5hZGRfdG9fcGFyZW50JykuYXR0cignY2hpbGRfY291bnQnLCBjb3VudCk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmFkZF90b19wYXJlbnQnKS5hdHRyKCdwYXJlbnRfY291bnQnLCBjb3VudCk7XG4gICAgICAgIGlmIChjb2xsZWN0aW9uTGVuZ3RoID4gMikge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucGFyZW50KCkucmVtb3ZlKCk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8vYWRkIHdyYXBwZXIgZGl2IGFyb3VuZCB0aGUgYXR0cmlidXRlc1xuICAgIEZvcm1CdWlsZGVyLnByb3RvdHlwZS5hZGRXcmFwcGVyID0gZnVuY3Rpb24gKCkge1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5tdWx0aS1mb3JtJykuZWFjaChmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcbiAgICAgICAgICAgICAgICAuZmluZCgnLmF0dHJpYnV0ZScpXG4gICAgICAgICAgICAgICAgLndyYXBBbGwoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCc8ZGl2IGNsYXNzPVwiZm9ybS1maWVsZC1ncm91cCBmbGV4IGZsZXgtd3JhcCByb3VuZGVkLWJyLWxnIGJvcmRlci15IGJvcmRlci1yIGJvcmRlci1zcHJpbmctNTAgYXR0cmlidXRlLXdyYXBwZXIgbWItNFwiPjwvZGl2PicpKTtcbiAgICAgICAgfSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLnN1YmVsZW1lbnQnKVxuICAgICAgICAgICAgLmZpbmQoJy53cmFwcGVkLWNoaWxkLWJvZHknKVxuICAgICAgICAgICAgLmVhY2goZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpXG4gICAgICAgICAgICAgICAgLmZpbmQoJy5zdWItYXR0cmlidXRlJylcbiAgICAgICAgICAgICAgICAud3JhcEFsbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJzxkaXYgY2xhc3M9XCJmb3JtLWZpZWxkLWdyb3VwIGZsZXggZmxleC13cmFwIHJvdW5kZWQtYnItbGcgYm9yZGVyLXkgYm9yZGVyLXIgYm9yZGVyLXNwcmluZy01MCBzdWItYXR0cmlidXRlLXdyYXBwZXIgbWItNFwiPjwvZGl2PicpKTtcbiAgICAgICAgfSk7XG4gICAgICAgIHZhciBmb3JtRmllbGQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2Zvcm0+LmZvcm0tZmllbGQnKTtcbiAgICAgICAgaWYgKGZvcm1GaWVsZC5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBmb3JtRmllbGQud3JhcEFsbCgnPGRpdiBjbGFzcz1cImZvcm0tZmllbGQtZ3JvdXAtb3V0ZXIgZ3JpZCB4bDpncmlkLWNvbHMtMiBtYi02IC1teC0zIGdhcC15LTZcIj48L2Rpdj4nKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgRm9ybUJ1aWxkZXIucHJvdG90eXBlLmFkZFdyYXBwZXJPbkFkZCA9IGZ1bmN0aW9uICh0YXJnZXQpIHtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldClcbiAgICAgICAgICAgIC5wcmV2KClcbiAgICAgICAgICAgIC5maW5kKCcubXVsdGktZm9ybScpXG4gICAgICAgICAgICAubGFzdCgpXG4gICAgICAgICAgICAuZmluZCgnLmF0dHJpYnV0ZScpXG4gICAgICAgICAgICAud3JhcEFsbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJzxkaXYgY2xhc3M9XCJmb3JtLWZpZWxkLWdyb3VwIGdyaWQgeGw6Z3JpZC1jb2xzLTIgcm91bmRlZC1ici1sZyBib3JkZXIteSBib3JkZXItciBib3JkZXItc3ByaW5nLTUwIGF0dHJpYnV0ZS13cmFwcGVyIG1iLTRcIj48L2Rpdj4nKSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXG4gICAgICAgICAgICAucHJldigpXG4gICAgICAgICAgICAuZmluZCgnLm11bHRpLWZvcm0nKVxuICAgICAgICAgICAgLmxhc3QoKVxuICAgICAgICAgICAgLmZpbmQoJy5zdWJlbGVtZW50JylcbiAgICAgICAgICAgIC5maW5kKCcud3JhcHBlZC1jaGlsZC1ib2R5JylcbiAgICAgICAgICAgIC5lYWNoKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKVxuICAgICAgICAgICAgICAgIC5maW5kKCcuc3ViLWF0dHJpYnV0ZScpXG4gICAgICAgICAgICAgICAgLndyYXBBbGwoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCc8ZGl2IGNsYXNzPVwiZm9ybS1maWVsZC1ncm91cCBmbGV4IGZsZXgtd3JhcCByb3VuZGVkLWJyLWxnIGJvcmRlci15IGJvcmRlci1yIGJvcmRlci1zcHJpbmctNTAgc3ViLWF0dHJpYnV0ZS13cmFwcGVyIG1iLTRcIj48L2Rpdj4nKSk7XG4gICAgICAgIH0pO1xuICAgIH07XG4gICAgRm9ybUJ1aWxkZXIucHJvdG90eXBlLnRleHRBcmVhSGVpZ2h0ID0gZnVuY3Rpb24gKGV2KSB7XG4gICAgICAgIHZhciB0YXJnZXQgPSBldi50YXJnZXQ7XG4gICAgICAgIHZhciBoZWlnaHQgPSB0YXJnZXQuc2Nyb2xsSGVpZ2h0O1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5jc3MoJ2hlaWdodCcsIGhlaWdodCk7XG4gICAgfTtcbiAgICBGb3JtQnVpbGRlci5wcm90b3R5cGUuYWRkVG9Db2xsZWN0aW9uID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCAnLmFkZF90b19jb2xsZWN0aW9uJywgZnVuY3Rpb24gKGV2ZW50KSB7XG4gICAgICAgICAgICBpZiAoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGV2ZW50LnRhcmdldCkuaGFzQ2xhc3MoJ2FkZC1pY29uJykpIHtcbiAgICAgICAgICAgICAgICBldmVudC5zdG9wUHJvcGFnYXRpb24oKTtcbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoZXZlbnQudGFyZ2V0KVxuICAgICAgICAgICAgICAgICAgICAucGFyZW50KCdidXR0b24nKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2xpY2snKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgICAgIF90aGlzLmFkZEZvcm0oZXZlbnQpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX3BhcmVudCcpLm9uKCdjbGljaycsIGZ1bmN0aW9uIChldmVudCkge1xuICAgICAgICAgICAgaWYgKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShldmVudC50YXJnZXQpLmhhc0NsYXNzKCdhZGQtaWNvbicpKSB7XG4gICAgICAgICAgICAgICAgZXZlbnQuc3RvcFByb3BhZ2F0aW9uKCk7XG4gICAgICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGV2ZW50LnRhcmdldClcbiAgICAgICAgICAgICAgICAgICAgLnBhcmVudCgnYnV0dG9uJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NsaWNrJyk7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgICAgICBfdGhpcy5hZGRQYXJlbnRGb3JtKGV2ZW50KTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSk7XG4gICAgfTtcbiAgICBGb3JtQnVpbGRlci5wcm90b3R5cGUuZGVsZXRlQ29sbGVjdGlvbiA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgdmFyIGRlbGV0ZUNvbmZpcm1hdGlvbiA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmRlbGV0ZS1jb25maXJtYXRpb24nKSwgY2FuY2VsUG9wdXAgPSAnLmNhbmNlbC1wb3B1cCcsIGRlbGV0ZUNvbmZpcm0gPSAnLmRlbGV0ZS1jb25maXJtJztcbiAgICAgICAgdmFyIGRlbGV0ZUluZGV4ID0ge30sIGNoaWxkT3JQYXJlbnQgPSAnJztcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgJy5kZWxldGUnLCBmdW5jdGlvbiAoZXZlbnQpIHtcbiAgICAgICAgICAgIGRlbGV0ZUNvbmZpcm1hdGlvbi5mYWRlSW4oKTtcbiAgICAgICAgICAgIGRlbGV0ZUluZGV4ID0gZXZlbnQ7XG4gICAgICAgICAgICBjaGlsZE9yUGFyZW50ID0gJ2NoaWxkJztcbiAgICAgICAgfSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsIGNhbmNlbFBvcHVwLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICBkZWxldGVDb25maXJtYXRpb24uZmFkZU91dCgpO1xuICAgICAgICAgICAgZGVsZXRlSW5kZXggPSB7fTtcbiAgICAgICAgICAgIGNoaWxkT3JQYXJlbnQgPSAnJztcbiAgICAgICAgfSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsIGRlbGV0ZUNvbmZpcm0sIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgIGlmIChjaGlsZE9yUGFyZW50ID09PSAnY2hpbGQnKSB7XG4gICAgICAgICAgICAgICAgX3RoaXMuZGVsZXRlRm9ybShkZWxldGVJbmRleCk7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBlbHNlIGlmIChjaGlsZE9yUGFyZW50ID09PSAncGFyZW50Jykge1xuICAgICAgICAgICAgICAgIF90aGlzLmRlbGV0ZVBhcmVudEZvcm0oZGVsZXRlSW5kZXgpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZGVsZXRlQ29uZmlybWF0aW9uLmZhZGVPdXQoKTtcbiAgICAgICAgICAgIGRlbGV0ZUluZGV4ID0ge307XG4gICAgICAgICAgICBjaGlsZE9yUGFyZW50ID0gJyc7XG4gICAgICAgIH0pO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCAnLmRlbGV0ZS1wYXJlbnQnLCBmdW5jdGlvbiAoZXZlbnQpIHtcbiAgICAgICAgICAgIGRlbGV0ZUNvbmZpcm1hdGlvbi5mYWRlSW4oKTtcbiAgICAgICAgICAgIGRlbGV0ZUluZGV4ID0gZXZlbnQ7XG4gICAgICAgICAgICBjaGlsZE9yUGFyZW50ID0gJ3BhcmVudCc7XG4gICAgICAgIH0pO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5zZWxlY3QyJykuc2VsZWN0Mih7XG4gICAgICAgICAgICBwbGFjZWhvbGRlcjogJ1NlbGVjdCBhbiBvcHRpb24nLFxuICAgICAgICAgICAgYWxsb3dDbGVhcjogdHJ1ZSxcbiAgICAgICAgfSk7XG4gICAgICAgIC8vIHVwZGF0ZSBmb3JtYXQgb24gY2hhbmdlIG9mIGRvY3VtZW50IGxpbmtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NoYW5nZScsICdpbnB1dFtpZCo9XCJbdXJsXVwiXScsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICB2YXIgZmlsZVBhdGggPSAoKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpLnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnJykudG9TdHJpbmcoKTtcbiAgICAgICAgICAgIHZhciBkb2N1bWVudCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKVxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgLmZpbmQoJ2lucHV0W2lkKj1cIltkb2N1bWVudF1cIl0nKVxuICAgICAgICAgICAgICAgIC52YWwoKTtcbiAgICAgICAgICAgIHZhciB1cmwgPSBcIi9taW1ldHlwZT91cmw9XCIuY29uY2F0KGZpbGVQYXRoLCBcIiZ0eXBlPXVybFwiKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS5jbG9zZXN0KCcuZm9ybS1maWVsZCcpLmZpbmQoJy50ZXh0LWRhbmdlcicpLnJlbW92ZSgpO1xuICAgICAgICAgICAgaWYgKGZpbGVQYXRoICE9PSAnJykge1xuICAgICAgICAgICAgICAgIGF4aW9zXzEuZGVmYXVsdC5nZXQodXJsKS50aGVuKGZ1bmN0aW9uIChyZXNwb25zZSkge1xuICAgICAgICAgICAgICAgICAgICBpZiAocmVzcG9uc2UuZGF0YS5zdWNjZXNzKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgZm9ybWF0ID0gcmVzcG9uc2UuZGF0YS5kYXRhLm1pbWV0eXBlO1xuICAgICAgICAgICAgICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKF90aGlzKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLmZpbmQoJ3NlbGVjdFtpZCo9XCJbZm9ybWF0XVwiXScpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLnZhbChmb3JtYXQpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKF90aGlzKS5jbG9zZXN0KCcuZm9ybS1maWVsZCcpLmZpbmQoJy50ZXh0LWRhbmdlcicpLnJlbW92ZSgpO1xuICAgICAgICAgICAgICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKF90aGlzKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLmFwcGVuZChcIjxkaXYgY2xhc3M9J3RleHQtZGFuZ2VyIGVycm9yJz5cIiArXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgcmVzcG9uc2UuZGF0YS5tZXNzYWdlICtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAnPC9kaXY+Jyk7XG4gICAgICAgICAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoX3RoaXMpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAuZmluZCgnc2VsZWN0W2lkKj1cIltmb3JtYXRdXCJdJylcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoX3RoaXMpXG4gICAgICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAgICAgLmZpbmQoJ2lucHV0W2lkKj1cIltkb2N1bWVudF1cIl0nKVxuICAgICAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKTtcbiAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2UgaWYgKCFkb2N1bWVudCB8fCBkb2N1bWVudCA9PT0gJycpIHtcbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoJ3NlbGVjdFtpZCo9XCJbZm9ybWF0XVwiXScpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjaGFuZ2UnLCAnaW5wdXRbaWQqPVwiW2RvY3VtZW50XVwiXScsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICB2YXIgZmlsZVBhdGggPSAoKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpLnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnJykudG9TdHJpbmcoKTtcbiAgICAgICAgICAgIHZhciB1cmwgPSBcIi9taW1ldHlwZT91cmw9XCIuY29uY2F0KGZpbGVQYXRoLCBcIiYmdHlwZT1kb2N1bWVudFwiKTtcbiAgICAgICAgICAgIHZhciBmaWxlVXJsID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpXG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAuZmluZCgnaW5wdXRbaWQqPVwiW3VybF1cIl0nKVxuICAgICAgICAgICAgICAgIC52YWwoKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS5jbG9zZXN0KCcuZm9ybS1maWVsZCcpLmZpbmQoJy50ZXh0LWRhbmdlcicpLnJlbW92ZSgpO1xuICAgICAgICAgICAgaWYgKGZpbGVQYXRoICE9PSAnJykge1xuICAgICAgICAgICAgICAgIGF4aW9zXzEuZGVmYXVsdC5nZXQodXJsKS50aGVuKGZ1bmN0aW9uIChyZXNwb25zZSkge1xuICAgICAgICAgICAgICAgICAgICBpZiAocmVzcG9uc2UuZGF0YS5zdWNjZXNzKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgZm9ybWF0ID0gcmVzcG9uc2UuZGF0YS5kYXRhLm1pbWV0eXBlO1xuICAgICAgICAgICAgICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKF90aGlzKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLmZpbmQoJ3NlbGVjdFtpZCo9XCJbZm9ybWF0XVwiXScpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLnZhbChmb3JtYXQpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKF90aGlzKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLmZpbmQoJ3NlbGVjdFtpZCo9XCJbZm9ybWF0XVwiXScpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJyk7XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoJ2lucHV0W2lkKj1cIlt1cmxdXCJdJylcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZWxzZSBpZiAoIWZpbGVVcmwgfHwgZmlsZVVybCA9PT0gJycpIHtcbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoJ3NlbGVjdFtpZCo9XCJbZm9ybWF0XVwiXScpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSk7XG4gICAgfTtcbiAgICByZXR1cm4gRm9ybUJ1aWxkZXI7XG59KCkpO1xuKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGZ1bmN0aW9uICgpIHtcbiAgICB2YXIgZm9ybUJ1aWxkZXIgPSBuZXcgRm9ybUJ1aWxkZXIoKTtcbiAgICBmb3JtQnVpbGRlci5hZGRXcmFwcGVyKCk7XG4gICAgZHluYW1pY0ZpZWxkLmhpZGVTaG93Rm9ybUZpZWxkcygpO1xuICAgIGR5bmFtaWNGaWVsZC51cGRhdGVBY3Rpdml0eUlkZW50aWZpZXIoKTtcbiAgICBmb3JtQnVpbGRlci5hZGRUb0NvbGxlY3Rpb24oKTtcbiAgICBmb3JtQnVpbGRlci5kZWxldGVDb2xsZWN0aW9uKCk7XG4gICAgLyoqXG4gICAgICogVGV4dCBhcmVhIGhlaWdodCBvbiB0eXBpbmdcbiAgICAgKi9cbiAgICB2YXIgdGV4dEFyZWFUYXJnZXQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3RleHRhcmVhLmZvcm1fX2lucHV0Jyk7XG4gICAgaWYgKHRleHRBcmVhVGFyZ2V0Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2lucHV0JywgJ3RleHRhcmVhLmZvcm1fX2lucHV0JywgZnVuY3Rpb24gKGV2ZW50KSB7XG4gICAgICAgICAgICBmb3JtQnVpbGRlci50ZXh0QXJlYUhlaWdodChldmVudCk7XG4gICAgICAgIH0pO1xuICAgIH1cbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignc2VsZWN0MjpvcGVuJywgJy5zZWxlY3QyJywgZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgc2VsZWN0X3NlYXJjaCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5zZWxlY3QyLXNlYXJjaF9fZmllbGQnKTtcbiAgICAgICAgaWYgKHNlbGVjdF9zZWFyY2gpIHtcbiAgICAgICAgICAgIHNlbGVjdF9zZWFyY2guZm9jdXMoKTtcbiAgICAgICAgfVxuICAgIH0pO1xuICAgIC8qKlxuICAgICAqIGNoZWNrcyByZWdpc3RyYXRpb24gYWdlbmN5LCBjb3VudHJ5IGFuZCByZWdpc3RyYXRpb24gbnVtYmVyIHRvIGRlZHVjZSBpZGVudGlmaWVyXG4gICAgICovXG4gICAgdXBkYXRlUmVnaXN0cmF0aW9uQWdlbmN5KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI29yZ2FuaXphdGlvbl9jb3VudHJ5JykpO1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI29yZ2FuaXNhdGlvbl9pZGVudGlmaWVyJykuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKTtcbiAgICBmdW5jdGlvbiB1cGRhdGVSZWdpc3RyYXRpb25BZ2VuY3koY291bnRyeSkge1xuICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmFqYXgoeyB1cmw6ICcvb3JnYW5pc2F0aW9uL2FnZW5jeS8nICsgY291bnRyeS52YWwoKSB9KS50aGVuKGZ1bmN0aW9uIChyZXNwb25zZSkge1xuICAgICAgICAgICAgdmFyIF9hO1xuICAgICAgICAgICAgdmFyIGN1cnJlbnRfdmFsID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjb3JnYW5pemF0aW9uX3JlZ2lzdHJhdGlvbl9hZ2VuY3knKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJyc7XG4gICAgICAgICAgICB2YXIgdmFsID0gZmFsc2U7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScpLmVtcHR5KCk7XG4gICAgICAgICAgICBmb3IgKHZhciBkYXRhIGluIHJlc3BvbnNlLmRhdGEpIHtcbiAgICAgICAgICAgICAgICBpZiAoZGF0YSA9PT0gY3VycmVudF92YWwpIHtcbiAgICAgICAgICAgICAgICAgICAgdmFsID0gdHJ1ZTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjb3JnYW5pemF0aW9uX3JlZ2lzdHJhdGlvbl9hZ2VuY3knKVxuICAgICAgICAgICAgICAgICAgICAuYXBwZW5kKG5ldyBPcHRpb24ocmVzcG9uc2UuZGF0YVtkYXRhXSwgZGF0YSwgdHJ1ZSwgdHJ1ZSkpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI29yZ2FuaXphdGlvbl9yZWdpc3RyYXRpb25fYWdlbmN5JylcbiAgICAgICAgICAgICAgICAudmFsKHZhbCA/IGN1cnJlbnRfdmFsIDogJycpXG4gICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpO1xuICAgICAgICB9KTtcbiAgICB9XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ3NlbGVjdDI6c2VsZWN0JywgJyNvcmdhbml6YXRpb25fY291bnRyeScsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdXBkYXRlUmVnaXN0cmF0aW9uQWdlbmN5KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKSk7XG4gICAgfSk7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ3NlbGVjdDI6Y2xlYXInLCAnI29yZ2FuaXphdGlvbl9jb3VudHJ5JywgZnVuY3Rpb24gKCkge1xuICAgICAgICB1cGRhdGVSZWdpc3RyYXRpb25BZ2VuY3koKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpKTtcbiAgICB9KTtcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignc2VsZWN0MjpzZWxlY3QnLCAnI29yZ2FuaXphdGlvbl9yZWdpc3RyYXRpb25fYWdlbmN5JywgZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgaWRlbnRpZmllciA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS52YWwoKSArICctJyArICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI3JlZ2lzdHJhdGlvbl9udW1iZXInKS52YWwoKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjb3JnYW5pc2F0aW9uX2lkZW50aWZpZXInKS52YWwoaWRlbnRpZmllcik7XG4gICAgfSk7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ3NlbGVjdDI6Y2xlYXInLCAnI29yZ2FuaXphdGlvbl9yZWdpc3RyYXRpb25fYWdlbmN5JywgZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgaWRlbnRpZmllciA9ICctJyArICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI3JlZ2lzdHJhdGlvbl9udW1iZXInKS52YWwoKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjb3JnYW5pc2F0aW9uX2lkZW50aWZpZXInKS52YWwoaWRlbnRpZmllcik7XG4gICAgfSk7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2tleXVwJywgJyNyZWdpc3RyYXRpb25fbnVtYmVyJywgZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgaWRlbnRpZmllciA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI29yZ2FuaXphdGlvbl9yZWdpc3RyYXRpb25fYWdlbmN5JykudmFsKCkgKyAnLScgKyAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykudmFsKCk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI29yZ2FuaXNhdGlvbl9pZGVudGlmaWVyJykudmFsKGlkZW50aWZpZXIpO1xuICAgIH0pO1xuICAgIC8vIGFkZCBjbGFzcyB0byB0aXRsZSBvZiBjb2xsZWN0aW9uIHdoZW4gdmFsaWRhdGlvbiBlcnJvciBvY2N1cnMgb24gY29sbGVjdGlvbiBsZXZlbFxuICAgIHZhciBzdWJlbGVtZW50ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLnN1YmVsZW1lbnQnKTtcbiAgICBmb3IgKHZhciBpID0gMDsgaSA8IHN1YmVsZW1lbnQubGVuZ3RoOyBpKyspIHtcbiAgICAgICAgdmFyIHRpdGxlID0gc3ViZWxlbWVudFtpXS5xdWVyeVNlbGVjdG9yKCcuY29udHJvbC1sYWJlbCcpO1xuICAgICAgICB2YXIgZXJyb3JDb250YWluZXIgPSBzdWJlbGVtZW50W2ldLnF1ZXJ5U2VsZWN0b3IoJy5jb2xsZWN0aW9uX2Vycm9yJyk7XG4gICAgICAgIHZhciBjaGlsZENvdW50ID0gZXJyb3JDb250YWluZXIgPT09IG51bGwgfHwgZXJyb3JDb250YWluZXIgPT09IHZvaWQgMCA/IHZvaWQgMCA6IGVycm9yQ29udGFpbmVyLmNoaWxkRWxlbWVudENvdW50O1xuICAgICAgICBpZiAoY2hpbGRDb3VudCAmJiBjaGlsZENvdW50ID4gMCkge1xuICAgICAgICAgICAgdGl0bGUgPT09IG51bGwgfHwgdGl0bGUgPT09IHZvaWQgMCA/IHZvaWQgMCA6IHRpdGxlLmNsYXNzTGlzdC5hZGQoJ2Vycm9yLXRpdGxlJyk7XG4gICAgICAgIH1cbiAgICB9XG4gICAgLy8gQWRkaW5nIGN1cnNvciBub3QgYWxsb3dlZCB0byA8c2VsZWN0PiB3aGVyZSBlbGVtZW50SnNvblNjaGVtYSByZWFkX29ubHkgOiB0cnVlXG4gICAgdmFyIHJlYWRPbmx5U2VsZWN0cyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJ3NlbGVjdC5jdXJzb3Itbm90LWFsbG93ZWQnKTtcbiAgICBmb3IgKHZhciBpID0gMDsgaSA8IHJlYWRPbmx5U2VsZWN0cy5sZW5ndGg7IGkrKykge1xuICAgICAgICB2YXIgc2VsZWN0ID0gcmVhZE9ubHlTZWxlY3RzW2ldO1xuICAgICAgICB2YXIgc2VsZWN0RWxlbWVudFBhcmVudFdyYXBwZXIgPSBzZWxlY3QubmV4dFNpYmxpbmc7XG4gICAgICAgIHZhciBzZWxlY3RFbGVtZW50UGFyZW50ID0gc2VsZWN0RWxlbWVudFBhcmVudFdyYXBwZXIgPT09IG51bGwgfHwgc2VsZWN0RWxlbWVudFBhcmVudFdyYXBwZXIgPT09IHZvaWQgMCA/IHZvaWQgMCA6IHNlbGVjdEVsZW1lbnRQYXJlbnRXcmFwcGVyLmZpcnN0Q2hpbGQ7XG4gICAgICAgIHZhciBzZWxlY3RFbGVtZW50ID0gc2VsZWN0RWxlbWVudFBhcmVudCA9PT0gbnVsbCB8fCBzZWxlY3RFbGVtZW50UGFyZW50ID09PSB2b2lkIDAgPyB2b2lkIDAgOiBzZWxlY3RFbGVtZW50UGFyZW50LmZpcnN0Q2hpbGQ7XG4gICAgICAgIGlmIChzZWxlY3RFbGVtZW50KSB7XG4gICAgICAgICAgICBzZWxlY3RFbGVtZW50LnN0eWxlLmN1cnNvciA9ICdub3QtYWxsb3dlZCc7XG4gICAgICAgIH1cbiAgICB9XG59KTtcbiJdLCJuYW1lcyI6WyJfX2ltcG9ydERlZmF1bHQiLCJtb2QiLCJfX2VzTW9kdWxlIiwiT2JqZWN0IiwiZGVmaW5lUHJvcGVydHkiLCJleHBvcnRzIiwidmFsdWUiLCJEeW5hbWljRmllbGQiLCJqcXVlcnlfMSIsInJlcXVpcmUiLCJwcm90b3R5cGUiLCJoaWRlU2hvd0Zvcm1GaWVsZHMiLCJodW1hbml0YXJpYW5TY29wZUhpZGVWb2NhYnVsYXJ5VXJpIiwiY291bnRyeUJ1ZGdldEhpZGVDb2RlRmllbGQiLCJhaWRUeXBlVm9jYWJ1bGFyeUhpZGVGaWVsZCIsInNlY3RvclZvY2FidWxhcnlIaWRlRmllbGQiLCJwb2xpY3lWb2NhYnVsYXJ5SGlkZUZpZWxkIiwicmVjaXBpZW50Vm9jYWJ1bGFyeUhpZGVGaWVsZCIsInRhZ1ZvY2FidWxhcnlIaWRlRmllbGQiLCJ0cmFuc2FjdGlvbkFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkIiwiaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkVXJpIiwiX3RoaXMiLCJodW1hbml0YXJpYW5TY29wZVZvY2FidWxhcnkiLCJsZW5ndGgiLCJlYWNoIiwiaW5kZXgiLCJzY29wZSIsIl9hIiwidmFsIiwiaGlkZUh1bWFuaXRhcmlhblNjb3BlRmllbGQiLCJ0b1N0cmluZyIsIm9uIiwiZSIsInBhcmFtcyIsImRhdGEiLCJpZCIsInRhcmdldCIsImNsb3Nlc3QiLCJmaW5kIiwic2hvdyIsInJlbW92ZUF0dHIiLCJ0cmlnZ2VyIiwiaGlkZSIsImF0dHIiLCJyZWZlcmVuY2VWb2NhYnVsYXJ5IiwiaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkIiwicmVmZXJlbmNlVXJpIiwiY291bnRyeUJ1ZGdldFZvY2FidWxhcnkiLCJoaWRlQ291bnRyeUJ1ZGdldEZpZWxkIiwiY291bnRyeUJ1ZGdldENvZGVJbnB1dCIsImNvdW50cnlCdWRnZXRDb2RlU2VsZWN0IiwiYWlkdHlwZV92b2NhYnVsYXJ5IiwiaXRlbSIsImhpZGVBaWRUeXBlU2VsZWN0RmllbGQiLCJoaWRlVHJhbnNhY3Rpb25BaWRUeXBlU2VsZWN0RmllbGQiLCJkZWZhdWx0X2FpZF90eXBlIiwiZWFybWFya2luZ19jYXRlZ29yeSIsImVhcm1hcmtpbmdfbW9kYWxpdHkiLCJjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXMiLCJjYXNlMSIsImNhc2UyIiwiY2FzZTMiLCJjYXNlNCIsImFpZF90eXBlIiwicG9saWN5bWFrZXJfdm9jYWJ1bGFyeSIsInBvbGljeV9tYXJrZXIiLCJoaWRlUG9saWN5TWFrZXJGaWVsZCIsImNhc2UxX3Nob3ciLCJjYXNlMl9zaG93Iiwic2VjdG9yX3ZvY2FidWxhcnkiLCJzZWN0b3IiLCJoaWRlU2VjdG9yRmllbGQiLCJjYXNlN19zaG93IiwiY2FzZThfc2hvdyIsImNhc2U5OF85OV9zaG93IiwiZGVmYXVsdF9zaG93IiwiY2FzZTciLCJjYXNlOCIsImNhc2U5OF85OSIsImRlZmF1bHRfaGlkZSIsInJlZ2lvbl92b2NhYnVsYXJ5IiwicmVnaW9uX3ZvY2FiIiwiaGlkZVJlY2lwaWVudFJlZ2lvbkZpZWxkIiwiY2FzZTk5X3Nob3ciLCJjYXNlOTkiLCJ1cGRhdGVBY3Rpdml0eUlkZW50aWZpZXIiLCJhY3Rpdml0eV9pZGVudGlmaWVyIiwiY29uY2F0IiwidGFnX3ZvY2FidWxhcnkiLCJ0YWciLCJoaWRlVGFnRmllbGQiLCJjYXNlM19zaG93IiwiYXhpb3NfMSIsIkR5bmFtaWNGaWVsZF8xIiwiZHluYW1pY0ZpZWxkIiwiRm9ybUJ1aWxkZXIiLCJhZGRGb3JtIiwiZXYiLCJwcmV2ZW50RGVmYXVsdCIsImNvbnRhaW5lciIsImNvdW50IiwicGFyc2VJbnQiLCJwYXJlbnQiLCJwYXJlbnRfY291bnQiLCJwYXJlbnRzIiwid3JhcHBlcl9wYXJlbnRfY291bnQiLCJwcm90byIsInJlcGxhY2UiLCJwcmV2IiwiYXBwZW5kIiwiY2hpbGRyZW4iLCJsYXN0Iiwic2VsZWN0MiIsInBsYWNlaG9sZGVyIiwiYWxsb3dDbGVhciIsIndyYXBBbGwiLCJhZGRQYXJlbnRGb3JtIiwiYWRkV3JhcHBlck9uQWRkIiwiZGVsZXRlRm9ybSIsImNvbGxlY3Rpb25MZW5ndGgiLCJ0ZyIsIm5leHQiLCJyZW1vdmUiLCJkZWxldGVQYXJlbnRGb3JtIiwiYWRkV3JhcHBlciIsImZvcm1GaWVsZCIsInRleHRBcmVhSGVpZ2h0IiwiaGVpZ2h0Iiwic2Nyb2xsSGVpZ2h0IiwiY3NzIiwiYWRkVG9Db2xsZWN0aW9uIiwiZXZlbnQiLCJoYXNDbGFzcyIsInN0b3BQcm9wYWdhdGlvbiIsImRlbGV0ZUNvbGxlY3Rpb24iLCJkZWxldGVDb25maXJtYXRpb24iLCJjYW5jZWxQb3B1cCIsImRlbGV0ZUNvbmZpcm0iLCJkZWxldGVJbmRleCIsImNoaWxkT3JQYXJlbnQiLCJmYWRlSW4iLCJmYWRlT3V0IiwiZmlsZVBhdGgiLCJkb2N1bWVudCIsInVybCIsImdldCIsInRoZW4iLCJyZXNwb25zZSIsInN1Y2Nlc3MiLCJmb3JtYXQiLCJtaW1ldHlwZSIsIm1lc3NhZ2UiLCJmaWxlVXJsIiwiZm9ybUJ1aWxkZXIiLCJ0ZXh0QXJlYVRhcmdldCIsInNlbGVjdF9zZWFyY2giLCJxdWVyeVNlbGVjdG9yIiwiZm9jdXMiLCJ1cGRhdGVSZWdpc3RyYXRpb25BZ2VuY3kiLCJjb3VudHJ5IiwiYWpheCIsImN1cnJlbnRfdmFsIiwiZW1wdHkiLCJPcHRpb24iLCJpZGVudGlmaWVyIiwic3ViZWxlbWVudCIsInF1ZXJ5U2VsZWN0b3JBbGwiLCJpIiwidGl0bGUiLCJlcnJvckNvbnRhaW5lciIsImNoaWxkQ291bnQiLCJjaGlsZEVsZW1lbnRDb3VudCIsImNsYXNzTGlzdCIsImFkZCIsInJlYWRPbmx5U2VsZWN0cyIsInNlbGVjdCIsInNlbGVjdEVsZW1lbnRQYXJlbnRXcmFwcGVyIiwibmV4dFNpYmxpbmciLCJzZWxlY3RFbGVtZW50UGFyZW50IiwiZmlyc3RDaGlsZCIsInNlbGVjdEVsZW1lbnQiLCJzdHlsZSIsImN1cnNvciJdLCJzb3VyY2VSb290IjoiIn0=
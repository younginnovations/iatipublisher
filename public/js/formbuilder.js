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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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R0FBR0YsbUJBQW1CLEtBQUssSUFBeEIsSUFBZ0NBLG1CQUFtQixLQUFLLEtBQUssQ0FBN0QsR0FBaUUsS0FBSyxDQUF0RSxHQUEwRUEsbUJBQW1CLENBQUNDLFVBQWxIOztJQUNBLElBQUlDLGFBQUosRUFBbUI7TUFDZkEsYUFBYSxDQUFDQyxLQUFkLENBQW9CQyxNQUFwQixHQUE2QixhQUE3QjtJQUNIO0VBQ0o7QUFDSixDQXJGRCIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3Jlc291cmNlcy9hc3NldHMvanMvc2NyaXB0cy9EeW5hbWljRmllbGQudHMiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9qcy9zY3JpcHRzL2Zvcm1idWlsZGVyLnRzIl0sInNvdXJjZXNDb250ZW50IjpbIlwidXNlIHN0cmljdFwiO1xudmFyIF9faW1wb3J0RGVmYXVsdCA9ICh0aGlzICYmIHRoaXMuX19pbXBvcnREZWZhdWx0KSB8fCBmdW5jdGlvbiAobW9kKSB7XG4gICAgcmV0dXJuIChtb2QgJiYgbW9kLl9fZXNNb2R1bGUpID8gbW9kIDogeyBcImRlZmF1bHRcIjogbW9kIH07XG59O1xuT2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFwiX19lc01vZHVsZVwiLCB7IHZhbHVlOiB0cnVlIH0pO1xuZXhwb3J0cy5EeW5hbWljRmllbGQgPSB2b2lkIDA7XG52YXIganF1ZXJ5XzEgPSBfX2ltcG9ydERlZmF1bHQocmVxdWlyZShcImpxdWVyeVwiKSk7XG5yZXF1aXJlKFwic2VsZWN0MlwiKTtcbnZhciBEeW5hbWljRmllbGQgPSAvKiogQGNsYXNzICovIChmdW5jdGlvbiAoKSB7XG4gICAgZnVuY3Rpb24gRHluYW1pY0ZpZWxkKCkge1xuICAgIH1cbiAgICAvKipcbiAgICAgKiBIaWRlIGFuZCBTaG93IGRpZmZlcmVudCBmb3JtIGZpZWxkcyBiYXNlZCBvbiB2b2NhYnVsYXJ5IGFuZCBvdGhlciB0eXBlc1xuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaGlkZVNob3dGb3JtRmllbGRzID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB0aGlzLmh1bWFuaXRhcmlhblNjb3BlSGlkZVZvY2FidWxhcnlVcmkoKTtcbiAgICAgICAgdGhpcy5jb3VudHJ5QnVkZ2V0SGlkZUNvZGVGaWVsZCgpO1xuICAgICAgICB0aGlzLmFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIHRoaXMuc2VjdG9yVm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICB0aGlzLnBvbGljeVZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgdGhpcy5yZWNpcGllbnRWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIHRoaXMuc2VjdG9yVm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICB0aGlzLnRhZ1ZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgdGhpcy50cmFuc2FjdGlvbkFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIHRoaXMuaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkVXJpKCk7XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBIdW1hbml0YXJpYW4gU2NvcGUgRm9ybSBQYWdlXG4gICAgICpcbiAgICAgKiBATG9naWMgaGlkZSB2b2NhYnVsYXJ5LXVyaSBmaWVsZCBiYXNlZCBvbiAnQHZvY2FidWxhcnknIGZpZWxkIHZhbHVlXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5odW1hbml0YXJpYW5TY29wZUhpZGVWb2NhYnVsYXJ5VXJpID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuICAgICAgICB2YXIgaHVtYW5pdGFyaWFuU2NvcGVWb2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3RbaWRePVwiaHVtYW5pdGFyaWFuX3Njb3BlXCJdW2lkKj1cIlt2b2NhYnVsYXJ5XVwiXScpO1xuICAgICAgICBpZiAoaHVtYW5pdGFyaWFuU2NvcGVWb2NhYnVsYXJ5Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIC8vIGhpZGUgZmllbGRzIG9uIHBhZ2UgbG9hZFxuICAgICAgICAgICAganF1ZXJ5XzEuZGVmYXVsdC5lYWNoKGh1bWFuaXRhcmlhblNjb3BlVm9jYWJ1bGFyeSwgZnVuY3Rpb24gKGluZGV4LCBzY29wZSkge1xuICAgICAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgICAgICB2YXIgdmFsID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHNjb3BlKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJyc7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZUh1bWFuaXRhcmlhblNjb3BlRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHNjb3BlKSwgdmFsLnRvU3RyaW5nKCkpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAvLyBoaWRlL3Nob3cgZmllbGRzIG9uIHZhbHVlIGNoYW5nZVxuICAgICAgICAgICAgaHVtYW5pdGFyaWFuU2NvcGVWb2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOnNlbGVjdCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIHZhbCA9IGUucGFyYW1zLmRhdGEuaWQ7XG4gICAgICAgICAgICAgICAgdmFyIGluZGV4ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZUh1bWFuaXRhcmlhblNjb3BlRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGluZGV4KSwgdmFsKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgLy8gaGlkZS9zaG93IGZpZWxkcyBvbiB2YWx1ZSBjbGVhclxuICAgICAgICAgICAgaHVtYW5pdGFyaWFuU2NvcGVWb2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgaW5kZXggPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlSHVtYW5pdGFyaWFuU2NvcGVGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaW5kZXgpLCAnJyk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLy8gaGlkZSBjb3VudHJ5IGJ1ZGdldCBiYXNlZCBvbiB2b2NhYnVsYXJ5XG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5oaWRlSHVtYW5pdGFyaWFuU2NvcGVGaWVsZCA9IGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcbiAgICAgICAgdmFyIGh1bWFuaXRhcmlhblNjb3BlSGlkZVZvY2FidWxhcnlVcmkgPSAnaW5wdXRbaWRePVwiaHVtYW5pdGFyaWFuX3Njb3BlXCJdW2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0nO1xuICAgICAgICBpZiAodmFsdWUgPT09ICc5OScpIHtcbiAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAuZmluZChodW1hbml0YXJpYW5TY29wZUhpZGVWb2NhYnVsYXJ5VXJpKVxuICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgfVxuICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAuZmluZChodW1hbml0YXJpYW5TY29wZUhpZGVWb2NhYnVsYXJ5VXJpKVxuICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBIdW1hbml0YXJpYW4gU2NvcGUgRm9ybSBQYWdlXG4gICAgICpcbiAgICAgKiBATG9naWMgaGlkZSB2b2NhYnVsYXJ5LXVyaSBmaWVsZCBiYXNlZCBvbiAnQHZvY2FidWxhcnknIGZpZWxkIHZhbHVlXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5pbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGRVcmkgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgIHZhciByZWZlcmVuY2VWb2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3RbaWRePVwicmVmZXJlbmNlXCJdW2lkKj1cIlt2b2NhYnVsYXJ5XVwiXScpO1xuICAgICAgICBpZiAocmVmZXJlbmNlVm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICAvLyBoaWRlIGZpZWxkcyBvbiBwYWdlIGxvYWRcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuZWFjaChyZWZlcmVuY2VWb2NhYnVsYXJ5LCBmdW5jdGlvbiAoaW5kZXgsIHNjb3BlKSB7XG4gICAgICAgICAgICAgICAgdmFyIF9hO1xuICAgICAgICAgICAgICAgIHZhciB2YWwgPSAoX2EgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoc2NvcGUpLnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnJztcbiAgICAgICAgICAgICAgICBfdGhpcy5pbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHNjb3BlKSwgdmFsLnRvU3RyaW5nKCkpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAvLyBoaWRlL3Nob3cgZmllbGRzIG9uIHZhbHVlIGNoYW5nZVxuICAgICAgICAgICAgcmVmZXJlbmNlVm9jYWJ1bGFyeS5vbignc2VsZWN0MjpzZWxlY3QnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciB2YWwgPSBlLnBhcmFtcy5kYXRhLmlkO1xuICAgICAgICAgICAgICAgIHZhciBpbmRleCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmluZGljYXRvclJlZmVyZW5jZUhpZGVGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaW5kZXgpLCB2YWwpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAvLyBoaWRlL3Nob3cgZmllbGRzIG9uIHZhbHVlIGNsZWFyXG4gICAgICAgICAgICByZWZlcmVuY2VWb2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgaW5kZXggPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5pbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGluZGV4KSwgJycpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8vIGhpZGUgY291bnRyeSBidWRnZXQgYmFzZWQgb24gdm9jYWJ1bGFyeVxuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkID0gZnVuY3Rpb24gKGluZGV4LCB2YWx1ZSkge1xuICAgICAgICB2YXIgcmVmZXJlbmNlVXJpID0gJ2lucHV0W2lkXj1cInJlZmVyZW5jZVwiXVtpZCo9XCJbaW5kaWNhdG9yX3VyaV1cIl0nO1xuICAgICAgICBpZiAodmFsdWUgPT09ICc5OScpIHtcbiAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAuZmluZChyZWZlcmVuY2VVcmkpXG4gICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICB9XG4gICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgIC5maW5kKHJlZmVyZW5jZVVyaSlcbiAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogQ291bnRyeSBCdWRnZXQgRm9ybSBQYWdlXG4gICAgICpcbiAgICAgKiBATG9naWMgc2hvdy9oaWRlICdjb2RlJyBmaWVsZCBiYXNlZCBvbiAnQHZvY2FidWxhcnknIGZpZWxkIHZhbHVlXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5jb3VudHJ5QnVkZ2V0SGlkZUNvZGVGaWVsZCA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgdmFyIF9hO1xuICAgICAgICB2YXIgY291bnRyeUJ1ZGdldFZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdCNjb3VudHJ5X2J1ZGdldF92b2NhYnVsYXJ5Jyk7XG4gICAgICAgIGlmIChjb3VudHJ5QnVkZ2V0Vm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICAvLyBoaWRlL3Nob3cgb24gcGFnZSBsb2FkXG4gICAgICAgICAgICB2YXIgdmFsID0gKF9hID0gY291bnRyeUJ1ZGdldFZvY2FidWxhcnkudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcxJztcbiAgICAgICAgICAgIHRoaXMuaGlkZUNvdW50cnlCdWRnZXRGaWVsZCh2YWwudG9TdHJpbmcoKSk7XG4gICAgICAgICAgICAvLyBoaWRlL3Nob3cgb24gdmFsdWUgY2hhbmdlXG4gICAgICAgICAgICBjb3VudHJ5QnVkZ2V0Vm9jYWJ1bGFyeS5vbignc2VsZWN0MjpzZWxlY3QnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciB2YWwgPSBlLnBhcmFtcy5kYXRhLmlkO1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVDb3VudHJ5QnVkZ2V0RmllbGQodmFsKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgLy9oaWRlL3Nob3cgYmFzZWQgb24gdmFsdWUgY2xlYXJlZFxuICAgICAgICAgICAgY291bnRyeUJ1ZGdldFZvY2FidWxhcnkub24oJ3NlbGVjdDI6Y2xlYXInLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZUNvdW50cnlCdWRnZXRGaWVsZCgnJyk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogSGlkZSBDb3VudHJ5IEJ1ZGdldCBGaWVsZHNcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmhpZGVDb3VudHJ5QnVkZ2V0RmllbGQgPSBmdW5jdGlvbiAodmFsdWUpIHtcbiAgICAgICAgdmFyIGNvdW50cnlCdWRnZXRDb2RlSW5wdXQgPSAnaW5wdXRbaWRePVwiYnVkZ2V0X2l0ZW1cIl1baWQqPVwiW2NvZGVfdGV4dF1cIl0nLCBjb3VudHJ5QnVkZ2V0Q29kZVNlbGVjdCA9ICdzZWxlY3RbaWRePVwiYnVkZ2V0X2l0ZW1cIl1baWQqPVwiW2NvZGVdXCJdJztcbiAgICAgICAgaWYgKHZhbHVlID09PSAnMScpIHtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShjb3VudHJ5QnVkZ2V0Q29kZVNlbGVjdClcbiAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGNvdW50cnlCdWRnZXRDb2RlSW5wdXQpXG4gICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgIH1cbiAgICAgICAgZWxzZSB7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoY291bnRyeUJ1ZGdldENvZGVTZWxlY3QpXG4gICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoY291bnRyeUJ1ZGdldENvZGVJbnB1dClcbiAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogQWlkVHlwZSBGb3JtIFBhZ2VcbiAgICAgKlxuICAgICAqIEBMb2dpYyBoaWRlIHZvY2FidWxhcnktdXJpIGFuZCBjb2RlcyBmaWVsZCBiYXNlZCBvbiAnQHZvY2FidWxhcnknIGZpZWxkIHZhbHVlXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5haWRUeXBlVm9jYWJ1bGFyeUhpZGVGaWVsZCA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgdmFyIGFpZHR5cGVfdm9jYWJ1bGFyeSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnc2VsZWN0W2lkKj1cImRlZmF1bHRfYWlkX3R5cGVfdm9jYWJ1bGFyeVwiXScpO1xuICAgICAgICBpZiAoYWlkdHlwZV92b2NhYnVsYXJ5Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuZWFjaChhaWR0eXBlX3ZvY2FidWxhcnksIGZ1bmN0aW9uIChpbmRleCwgaXRlbSkge1xuICAgICAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShpdGVtKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJzEnO1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVBaWRUeXBlU2VsZWN0RmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGl0ZW0pLCBkYXRhLnRvU3RyaW5nKCkpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICBhaWR0eXBlX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IGUucGFyYW1zLmRhdGEuaWQ7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVBaWRUeXBlU2VsZWN0RmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksIGRhdGEpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICBhaWR0eXBlX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6Y2xlYXInLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlQWlkVHlwZVNlbGVjdEZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCAnJyk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogQWlkVHlwZSBGb3JtIFBhZ2VcbiAgICAgKlxuICAgICAqIEBMb2dpYyBoaWRlIHZvY2FidWxhcnktdXJpIGFuZCBjb2RlcyBmaWVsZCBiYXNlZCBvbiAnQHZvY2FidWxhcnknIGZpZWxkIHZhbHVlXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS50cmFuc2FjdGlvbkFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuICAgICAgICB2YXIgYWlkdHlwZV92b2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3RbaWQqPVwiYWlkX3R5cGVfdm9jYWJ1bGFyeVwiXScpO1xuICAgICAgICBpZiAoYWlkdHlwZV92b2NhYnVsYXJ5Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuZWFjaChhaWR0eXBlX3ZvY2FidWxhcnksIGZ1bmN0aW9uIChpbmRleCwgaXRlbSkge1xuICAgICAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShpdGVtKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJzEnO1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVUcmFuc2FjdGlvbkFpZFR5cGVTZWxlY3RGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaXRlbSksIGRhdGEudG9TdHJpbmcoKSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIGFpZHR5cGVfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpzZWxlY3QnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gZS5wYXJhbXMuZGF0YS5pZDtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVRyYW5zYWN0aW9uQWlkVHlwZVNlbGVjdEZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCBkYXRhKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgYWlkdHlwZV92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVRyYW5zYWN0aW9uQWlkVHlwZVNlbGVjdEZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCAnJyk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogSGlkZSBBaWQgVHlwZSBTZWxlY3QgRmllbGRzXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5oaWRlQWlkVHlwZVNlbGVjdEZpZWxkID0gZnVuY3Rpb24gKGluZGV4LCB2YWx1ZSkge1xuICAgICAgICB2YXIgZGVmYXVsdF9haWRfdHlwZSA9ICdzZWxlY3RbaWQqPVwiW2RlZmF1bHRfYWlkX3R5cGVdXCJdJywgZWFybWFya2luZ19jYXRlZ29yeSA9ICdzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfY2F0ZWdvcnldXCJdJywgZWFybWFya2luZ19tb2RhbGl0eSA9ICdzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfbW9kYWxpdHldXCJdJywgY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzID0gJ3NlbGVjdFtpZCo9XCJbY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzXVwiXScsIGNhc2UxID0gJ3NlbGVjdFtpZCo9XCJbZWFybWFya2luZ19jYXRlZ29yeV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX21vZGFsaXR5XVwiXSxzZWxlY3RbaWQqPVwiW2Nhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllc11cIl0nLCBjYXNlMiA9ICdzZWxlY3RbaWQqPVwiW2RlZmF1bHRfYWlkX3R5cGVdXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19tb2RhbGl0eV1cIl0sc2VsZWN0W2lkKj1cIltjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXNdXCJdJywgY2FzZTMgPSAnc2VsZWN0W2lkKj1cIltkZWZhdWx0X2FpZF90eXBlXVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfY2F0ZWdvcnldXCJdLHNlbGVjdFtpZCo9XCJbY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzXVwiXScsIGNhc2U0ID0gJ3NlbGVjdFtpZCo9XCJbZGVmYXVsdF9haWRfdHlwZV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX2NhdGVnb3J5XVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfbW9kYWxpdHldXCJdJztcbiAgICAgICAgc3dpdGNoICh2YWx1ZSkge1xuICAgICAgICAgICAgY2FzZSAnMic6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoZWFybWFya2luZ19jYXRlZ29yeSlcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnMyc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoZWFybWFya2luZ19tb2RhbGl0eSlcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UzKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnNCc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTQpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBkZWZhdWx0OlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGRlZmF1bHRfYWlkX3R5cGUpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogSGlkZSBUcmFuc2FjdGlvbiBBaWQgVHlwZSBTZWxlY3QgRmllbGRzXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5oaWRlVHJhbnNhY3Rpb25BaWRUeXBlU2VsZWN0RmllbGQgPSBmdW5jdGlvbiAoaW5kZXgsIHZhbHVlKSB7XG4gICAgICAgIHZhciBhaWRfdHlwZSA9ICdzZWxlY3RbaWQqPVwiW2FpZF90eXBlX2NvZGVdXCJdJywgZWFybWFya2luZ19jYXRlZ29yeSA9ICdzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfY2F0ZWdvcnldXCJdJywgZWFybWFya2luZ19tb2RhbGl0eSA9ICdzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfbW9kYWxpdHldXCJdJywgY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzID0gJ3NlbGVjdFtpZCo9XCJbY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzXVwiXScsIGNhc2UxID0gJ3NlbGVjdFtpZCo9XCJbZWFybWFya2luZ19jYXRlZ29yeV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX21vZGFsaXR5XVwiXSxzZWxlY3RbaWQqPVwiW2Nhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllc11cIl0nLCBjYXNlMiA9ICdzZWxlY3RbaWQqPVwiW2FpZF90eXBlX2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19tb2RhbGl0eV1cIl0sc2VsZWN0W2lkKj1cIltjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXNdXCJdJywgY2FzZTMgPSAnc2VsZWN0W2lkKj1cIlthaWRfdHlwZV9jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfY2F0ZWdvcnldXCJdLHNlbGVjdFtpZCo9XCJbY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzXVwiXScsIGNhc2U0ID0gJ3NlbGVjdFtpZCo9XCJbYWlkX3R5cGVfY29kZV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX2NhdGVnb3J5XVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfbW9kYWxpdHldXCJdJztcbiAgICAgICAgc3dpdGNoICh2YWx1ZSkge1xuICAgICAgICAgICAgY2FzZSAnMic6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoZWFybWFya2luZ19jYXRlZ29yeSlcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnMyc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoZWFybWFya2luZ19tb2RhbGl0eSlcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UzKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnNCc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTQpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBkZWZhdWx0OlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGFpZF90eXBlKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTEpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIFBvbGljeSBNYXJrZXIgRm9ybSBQYWdlXG4gICAgICpcbiAgICAgKiBATG9naWMgaGlkZSB2b2NhYnVsYXJ5LXVyaSBhbmQgY29kZXMgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUucG9saWN5Vm9jYWJ1bGFyeUhpZGVGaWVsZCA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgdmFyIHBvbGljeW1ha2VyX3ZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdFtpZCo9XCJwb2xpY3lfbWFya2VyX3ZvY2FidWxhcnlcIl0nKTtcbiAgICAgICAgaWYgKHBvbGljeW1ha2VyX3ZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAganF1ZXJ5XzEuZGVmYXVsdC5lYWNoKHBvbGljeW1ha2VyX3ZvY2FidWxhcnksIGZ1bmN0aW9uIChpbmRleCwgcG9saWN5X21hcmtlcikge1xuICAgICAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShwb2xpY3lfbWFya2VyKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJzEnO1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVQb2xpY3lNYWtlckZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShwb2xpY3lfbWFya2VyKSwgZGF0YS50b1N0cmluZygpKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgcG9saWN5bWFrZXJfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpzZWxlY3QnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gZS5wYXJhbXMuZGF0YS5pZDtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVBvbGljeU1ha2VyRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksIGRhdGEpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICBwb2xpY3ltYWtlcl92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVBvbGljeU1ha2VyRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksICc5OScpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEhpZGVzIFBvbGljeSBNYXJrZXIgRm9ybSBGaWVsZHNcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmhpZGVQb2xpY3lNYWtlckZpZWxkID0gZnVuY3Rpb24gKGluZGV4LCB2YWx1ZSkge1xuICAgICAgICB2YXIgY2FzZTFfc2hvdyA9ICdzZWxlY3RbaWQqPVwiW3BvbGljeV9tYXJrZXJdXCJdJywgY2FzZTJfc2hvdyA9ICdpbnB1dFtpZCo9XCJbcG9saWN5X21hcmtlcl90ZXh0XVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdJywgY2FzZTEgPSAnaW5wdXRbaWQqPVwiW3BvbGljeV9tYXJrZXJfdGV4dF1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXScsIGNhc2UyID0gJ3NlbGVjdFtpZCo9XCJbcG9saWN5X21hcmtlcl1cIl0nO1xuICAgICAgICBzd2l0Y2ggKHZhbHVlKSB7XG4gICAgICAgICAgICBjYXNlICcxJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMV9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTEpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICc5OSc6XG4gICAgICAgICAgICBkZWZhdWx0OlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMilcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogU2VjdG9yIEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgYW5kIGNvZGVzIGZpZWxkIGJhc2VkIG9uICdAdm9jYWJ1bGFyeScgZmllbGQgdmFsdWVcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLnNlY3RvclZvY2FidWxhcnlIaWRlRmllbGQgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgIHZhciBzZWN0b3Jfdm9jYWJ1bGFyeSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnc2VsZWN0W2lkKj1cInNlY3Rvcl92b2NhYnVsYXJ5XCJdJyk7XG4gICAgICAgIGlmIChzZWN0b3Jfdm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2goc2VjdG9yX3ZvY2FidWxhcnksIGZ1bmN0aW9uIChpbmRleCwgc2VjdG9yKSB7XG4gICAgICAgICAgICAgICAgdmFyIF9hO1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHNlY3RvcikudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcxJztcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlU2VjdG9yRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHNlY3RvciksIGRhdGEudG9TdHJpbmcoKSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIHNlY3Rvcl92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOnNlbGVjdCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSBlLnBhcmFtcy5kYXRhLmlkO1xuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlU2VjdG9yRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksIGRhdGEpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICBzZWN0b3Jfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVTZWN0b3JGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgJycpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEhpZGUgU2VjdG9yIEZvcm0gZmllbGRzXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5oaWRlU2VjdG9yRmllbGQgPSBmdW5jdGlvbiAoaW5kZXgsIHZhbHVlKSB7XG4gICAgICAgIHZhciBjYXNlMV9zaG93ID0gJ3NlbGVjdFtpZCo9XCJbY29kZV1cIl0nLCBjYXNlMl9zaG93ID0gJ3NlbGVjdFtpZCo9XCJbY2F0ZWdvcnlfY29kZV1cIl0nLCBjYXNlN19zaG93ID0gJ3NlbGVjdFtpZCo9XCJbc2RnX2dvYWxdXCJdJywgY2FzZThfc2hvdyA9ICdzZWxlY3RbaWQqPVwiW3NkZ190YXJnZXRdXCJdJywgY2FzZTk4Xzk5X3Nob3cgPSAnaW5wdXRbaWQqPVwiW3RleHRdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0nLCBkZWZhdWx0X3Nob3cgPSAnaW5wdXRbaWQqPVwiW3RleHRdXCJdJywgY2FzZTEgPSAnc2VsZWN0W2lkKj1cIltjYXRlZ29yeV9jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ19nb2FsXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ190YXJnZXRdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0saW5wdXRbaWQqPVwiW3RleHRdXCJdJywgY2FzZTIgPSAnaW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ19nb2FsXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ190YXJnZXRdXCJdLHNlbGVjdFtpZCo9XCJbY29kZV1cIl0saW5wdXRbaWQqPVwiW3RleHRdXCJdJywgY2FzZTcgPSAnaW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSxzZWxlY3RbaWQqPVwiW2NhdGVnb3J5X2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX3RhcmdldF1cIl0sc2VsZWN0W2lkKj1cIltjb2RlXVwiXSxpbnB1dFtpZCo9XCJbdGV4dF1cIl0nLCBjYXNlOCA9ICdpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdLHNlbGVjdFtpZCo9XCJbY2F0ZWdvcnlfY29kZV1cIl0sc2VsZWN0W2lkKj1cIltzZGdfZ29hbF1cIl0sc2VsZWN0W2lkKj1cIltjb2RlXVwiXSxpbnB1dFtpZCo9XCJbdGV4dF1cIl0nLCBjYXNlOThfOTkgPSAnc2VsZWN0W2lkKj1cIltjYXRlZ29yeV9jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ19nb2FsXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ190YXJnZXRdXCJdLHNlbGVjdFtpZCo9XCJbY29kZV1cIl0nLCBkZWZhdWx0X2hpZGUgPSAnc2VsZWN0W2lkKj1cIltjYXRlZ29yeV9jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ19nb2FsXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ190YXJnZXRdXCJdLHNlbGVjdFtpZCo9XCJbY29kZV1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSc7XG4gICAgICAgIHN3aXRjaCAodmFsdWUpIHtcbiAgICAgICAgICAgIGNhc2UgJzEnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzInOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMilcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzcnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U3X3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlNylcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzgnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U4X3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOClcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzk4JzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOThfOTlfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U5OF85OSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzk5JzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOThfOTlfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U5OF85OSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGRlZmF1bHQ6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoZGVmYXVsdF9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoZGVmYXVsdF9oaWRlKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiAgUmVjaXBpZW50IFZvY2FidWxhcnkgRm9ybSBQYWdlXG4gICAgICpcbiAgICAgKiBATG9naWMgaGlkZSB2b2NhYnVsYXJ5LXVyaSBhbmQgY29kZXMgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUucmVjaXBpZW50Vm9jYWJ1bGFyeUhpZGVGaWVsZCA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgdmFyIHJlZ2lvbl92b2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3RbaWQqPVwicmVnaW9uX3ZvY2FidWxhcnlcIl0nKTtcbiAgICAgICAgaWYgKHJlZ2lvbl92b2NhYnVsYXJ5Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuZWFjaChyZWdpb25fdm9jYWJ1bGFyeSwgZnVuY3Rpb24gKGluZGV4LCByZWdpb25fdm9jYWIpIHtcbiAgICAgICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSAoX2EgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkocmVnaW9uX3ZvY2FiKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJzEnO1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVSZWNpcGllbnRSZWdpb25GaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkocmVnaW9uX3ZvY2FiKSwgZGF0YS50b1N0cmluZygpKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgcmVnaW9uX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IGUucGFyYW1zLmRhdGEuaWQ7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVSZWNpcGllbnRSZWdpb25GaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgZGF0YSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIHJlZ2lvbl92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVJlY2lwaWVudFJlZ2lvbkZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCAnJyk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogSGlkZXMgUmVjaXBpZW50IFJlZ2lvbiBGb3JtIEZpZWxkc1xuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaGlkZVJlY2lwaWVudFJlZ2lvbkZpZWxkID0gZnVuY3Rpb24gKGluZGV4LCB2YWx1ZSkge1xuICAgICAgICB2YXIgY2FzZTFfc2hvdyA9ICdzZWxlY3RbaWQqPVwiW3JlZ2lvbl9jb2RlXVwiXScsIGNhc2UyX3Nob3cgPSAnaW5wdXRbaWQqPVwiW2N1c3RvbV9jb2RlXVwiXSwgaW5wdXRbaWQqPVwiW2NvZGVdXCJdJywgY2FzZTk5X3Nob3cgPSAnaW5wdXRbaWQqPVwiW2N1c3RvbV9jb2RlXVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdLCBpbnB1dFtpZCo9XCJbY29kZV1cIl0nLCBjYXNlMSA9ICdpbnB1dFtpZCo9XCJbY3VzdG9tX2NvZGVdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0saW5wdXRbaWQqPVwiW2NvZGVdXCJdJywgY2FzZTIgPSAnc2VsZWN0W2lkKj1cIltyZWdpb25fY29kZV1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXScsIGNhc2U5OSA9ICdzZWxlY3RbaWQqPVwiW3JlZ2lvbl9jb2RlXVwiXSc7XG4gICAgICAgIHN3aXRjaCAodmFsdWUpIHtcbiAgICAgICAgICAgIGNhc2UgJzEnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzInOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMilcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzk5JzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOTlfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U5OSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGRlZmF1bHQ6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTJfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBVcGRhdGVzIEFjdGl2aXR5IGlkZW50aWZpZXJcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLnVwZGF0ZUFjdGl2aXR5SWRlbnRpZmllciA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIGFjdGl2aXR5X2lkZW50aWZpZXIgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNhY3Rpdml0eV9pZGVudGlmaWVyJyk7XG4gICAgICAgIGlmIChhY3Rpdml0eV9pZGVudGlmaWVyLmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIGFjdGl2aXR5X2lkZW50aWZpZXIub24oJ2tleXVwJywgZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI2lhdGlfaWRlbnRpZmllcl90ZXh0JykudmFsKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmlkZW50aWZpZXInKS5hdHRyKCdhY3Rpdml0eV9pZGVudGlmaWVyJykgKyBcIi1cIi5jb25jYXQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpLnZhbCgpKSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogVGFnIEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgYW5kIGNvZGVzIGZpZWxkIGJhc2VkIG9uICdAdm9jYWJ1bGFyeScgZmllbGQgdmFsdWVcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLnRhZ1ZvY2FidWxhcnlIaWRlRmllbGQgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgIHZhciB0YWdfdm9jYWJ1bGFyeSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnc2VsZWN0W2lkKj1cInRhZ192b2NhYnVsYXJ5XCJdJyk7XG4gICAgICAgIGlmICh0YWdfdm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2godGFnX3ZvY2FidWxhcnksIGZ1bmN0aW9uIChpbmRleCwgdGFnKSB7XG4gICAgICAgICAgICAgICAgdmFyIF9hO1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhZykudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcxJztcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlVGFnRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhZyksIGRhdGEudG9TdHJpbmcoKSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIHRhZ192b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOnNlbGVjdCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSBlLnBhcmFtcy5kYXRhLmlkO1xuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlVGFnRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksIGRhdGEpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICB0YWdfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVUYWdGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgJycpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEhpZGUgVGFnIEZvcm0gZmllbGRzXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5oaWRlVGFnRmllbGQgPSBmdW5jdGlvbiAoaW5kZXgsIHZhbHVlKSB7XG4gICAgICAgIHZhciBjYXNlMV9zaG93ID0gJ2lucHV0W2lkKj1cIlt0YWdfdGV4dF1cIl0nLCBjYXNlMl9zaG93ID0gJ3NlbGVjdFtpZCo9XCJbZ29hbHNfdGFnX2NvZGVdXCJdJywgY2FzZTNfc2hvdyA9ICdzZWxlY3RbaWQqPVwiW3RhcmdldHNfdGFnX2NvZGVdXCJdJywgY2FzZTk5X3Nob3cgPSAnaW5wdXRbaWQqPVwiW3RhZ190ZXh0XVwiXSwgaW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXScsIGNhc2UxID0gJ3NlbGVjdFtpZCo9XCJbZ29hbHNfdGFnX2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbdGFyZ2V0c190YWdfY29kZV1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXScsIGNhc2UyID0gJ2lucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0sc2VsZWN0W2lkKj1cIlt0YXJnZXRzX3RhZ19jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW3RhcmdldHNfdGFnX2NvZGVdXCJdLGlucHV0W2lkKj1cIlt0YWdfdGV4dF1cIl0nLCBjYXNlMyA9ICdpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdLHNlbGVjdFtpZCo9XCJbZ29hbHNfdGFnX2NvZGVdXCJdLGlucHV0W2lkKj1cIlt0YWdfdGV4dF1cIl0nLCBjYXNlOTkgPSAnc2VsZWN0W2lkKj1cIltnb2Fsc190YWdfY29kZV1cIl0sc2VsZWN0W2lkKj1cIlt0YXJnZXRzX3RhZ19jb2RlXVwiXSc7XG4gICAgICAgIHN3aXRjaCAodmFsdWUpIHtcbiAgICAgICAgICAgIGNhc2UgJzEnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzInOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMilcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzMnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UzX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMylcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzk5JzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOTlfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U5OSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGRlZmF1bHQ6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTFfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICByZXR1cm4gRHluYW1pY0ZpZWxkO1xufSgpKTtcbmV4cG9ydHMuRHluYW1pY0ZpZWxkID0gRHluYW1pY0ZpZWxkO1xuIiwiXCJ1c2Ugc3RyaWN0XCI7XG52YXIgX19pbXBvcnREZWZhdWx0ID0gKHRoaXMgJiYgdGhpcy5fX2ltcG9ydERlZmF1bHQpIHx8IGZ1bmN0aW9uIChtb2QpIHtcbiAgICByZXR1cm4gKG1vZCAmJiBtb2QuX19lc01vZHVsZSkgPyBtb2QgOiB7IFwiZGVmYXVsdFwiOiBtb2QgfTtcbn07XG5PYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgXCJfX2VzTW9kdWxlXCIsIHsgdmFsdWU6IHRydWUgfSk7XG52YXIgYXhpb3NfMSA9IF9faW1wb3J0RGVmYXVsdChyZXF1aXJlKFwiYXhpb3NcIikpO1xudmFyIGpxdWVyeV8xID0gX19pbXBvcnREZWZhdWx0KHJlcXVpcmUoXCJqcXVlcnlcIikpO1xucmVxdWlyZShcInNlbGVjdDJcIik7XG52YXIgRHluYW1pY0ZpZWxkXzEgPSByZXF1aXJlKFwiLi9EeW5hbWljRmllbGRcIik7XG52YXIgZHluYW1pY0ZpZWxkID0gbmV3IER5bmFtaWNGaWVsZF8xLkR5bmFtaWNGaWVsZCgpO1xudmFyIEZvcm1CdWlsZGVyID0gLyoqIEBjbGFzcyAqLyAoZnVuY3Rpb24gKCkge1xuICAgIGZ1bmN0aW9uIEZvcm1CdWlsZGVyKCkge1xuICAgIH1cbiAgICAvLyBhZGRzIG5ldyBjb2xsZWN0aW9uIG9mIHN1Yi1lbGVtZW50XG4gICAgRm9ybUJ1aWxkZXIucHJvdG90eXBlLmFkZEZvcm0gPSBmdW5jdGlvbiAoZXYpIHtcbiAgICAgICAgZXYucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgdmFyIHRhcmdldCA9IGV2LnRhcmdldDtcbiAgICAgICAgdmFyIGNvbnRhaW5lciA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2Zvcm1fdHlwZScpXG4gICAgICAgICAgICA/ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShcIi5jb2xsZWN0aW9uLWNvbnRhaW5lcltmb3JtX3R5cGUgPSdcIi5jb25jYXQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignZm9ybV90eXBlJyksIFwiJ11cIikpXG4gICAgICAgICAgICA6ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmNvbGxlY3Rpb24tY29udGFpbmVyJyk7XG4gICAgICAgIHZhciBjb3VudCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2NoaWxkX2NvdW50JylcbiAgICAgICAgICAgID8gcGFyc2VJbnQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignY2hpbGRfY291bnQnKSkgKyAxXG4gICAgICAgICAgICA6ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLnBhcmVudCgpLmZpbmQoJy5mb3JtLWNoaWxkLWJvZHknKS5sZW5ndGg7XG4gICAgICAgIHZhciBwYXJlbnRfY291bnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdwYXJlbnRfY291bnQnKVxuICAgICAgICAgICAgPyBwYXJzZUludCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdwYXJlbnRfY291bnQnKSlcbiAgICAgICAgICAgIDogKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucGFyZW50cygnLm11bHRpLWZvcm0nKS5pbmRleCgpIC0gMTtcbiAgICAgICAgdmFyIHdyYXBwZXJfcGFyZW50X2NvdW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignd3JhcHBlZF9wYXJlbnRfY291bnQnKVxuICAgICAgICAgICAgPyBwYXJzZUludCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCd3cmFwcGVkX3BhcmVudF9jb3VudCcpKVxuICAgICAgICAgICAgOiAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wYXJlbnRzKCcud3JhcHBlZC1jaGlsZC1ib2R5JykuaW5kZXgoKSAtIDE7XG4gICAgICAgIHZhciBwcm90byA9IGNvbnRhaW5lclxuICAgICAgICAgICAgLmRhdGEoJ3Byb3RvdHlwZScpXG4gICAgICAgICAgICAucmVwbGFjZSgvX19QQVJFTlRfTkFNRV9fL2csIHBhcmVudF9jb3VudCk7XG4gICAgICAgIGlmICgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdoYXNfY2hpbGRfY29sbGVjdGlvbicpKSB7XG4gICAgICAgICAgICBwcm90byA9IHByb3RvLnJlcGxhY2UoL19fV1JBUFBFUl9OQU1FX18vZywgY291bnQpO1xuICAgICAgICAgICAgcHJvdG8gPSBwcm90by5yZXBsYWNlKC9fX05BTUVfXy9nLCAwKTtcbiAgICAgICAgfVxuICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgIHByb3RvID0gcHJvdG8ucmVwbGFjZSgvX19OQU1FX18vZywgY291bnQpO1xuICAgICAgICAgICAgcHJvdG8gPSBwcm90by5yZXBsYWNlKC9fX1dSQVBQRVJfTkFNRV9fL2csIHdyYXBwZXJfcGFyZW50X2NvdW50KTtcbiAgICAgICAgfVxuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wcmV2KCkuYXBwZW5kKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShwcm90bykpO1xuICAgICAgICBpZiAoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignaGFzX2NoaWxkX2NvbGxlY3Rpb24nKSkge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldClcbiAgICAgICAgICAgICAgICAucHJldignLnN1YmVsZW1lbnQnKVxuICAgICAgICAgICAgICAgIC5jaGlsZHJlbignLndyYXBwZWQtY2hpbGQtYm9keScpXG4gICAgICAgICAgICAgICAgLmxhc3QoKVxuICAgICAgICAgICAgICAgIC5maW5kKCcuYWRkX3RvX2NvbGxlY3Rpb24nKVxuICAgICAgICAgICAgICAgIC5hdHRyKCd3cmFwcGVkX3BhcmVudF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXG4gICAgICAgICAgICAgICAgLnByZXYoJy5zdWJlbGVtZW50JylcbiAgICAgICAgICAgICAgICAuY2hpbGRyZW4oJy53cmFwcGVkLWNoaWxkLWJvZHknKVxuICAgICAgICAgICAgICAgIC5sYXN0KClcbiAgICAgICAgICAgICAgICAuZmluZCgnLmFkZF90b19jb2xsZWN0aW9uJylcbiAgICAgICAgICAgICAgICAuYXR0cigncGFyZW50X2NvdW50JywgcGFyZW50X2NvdW50KTtcbiAgICAgICAgfVxuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KVxuICAgICAgICAgICAgLnByZXYoKVxuICAgICAgICAgICAgLmZpbmQoJy53cmFwcGVkLWNoaWxkLWJvZHknKVxuICAgICAgICAgICAgLmxhc3QoKVxuICAgICAgICAgICAgLmZpbmQoJy5hZGRfdG9fY29sbGVjdGlvbicpXG4gICAgICAgICAgICAuYXR0cignd3JhcHBlcl9wYXJlbnRfY291bnQnLCB3cmFwcGVyX3BhcmVudF9jb3VudCAhPT0gbnVsbCAmJiB3cmFwcGVyX3BhcmVudF9jb3VudCAhPT0gdm9pZCAwID8gd3JhcHBlcl9wYXJlbnRfY291bnQgOiAwKTtcbiAgICAgICAgaWYgKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2Zvcm1fdHlwZScpKSB7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wcmV2KCkubGFzdCgpLmZpbmQoJy5zZWxlY3QyJykuc2VsZWN0Mih7XG4gICAgICAgICAgICAgICAgcGxhY2Vob2xkZXI6ICdTZWxlY3QgYW4gb3B0aW9uJyxcbiAgICAgICAgICAgICAgICBhbGxvd0NsZWFyOiB0cnVlLFxuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcbiAgICAgICAgICAgICAgICAuZmluZCgnLnN1Yi1hdHRyaWJ1dGUnKVxuICAgICAgICAgICAgICAgIC53cmFwQWxsKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnPGRpdiBjbGFzcz1cImZvcm0tZmllbGQtZ3JvdXAgZmxleCBmbGV4LXdyYXAgcm91bmRlZC1ici1sZyBib3JkZXIteSBib3JkZXItciBib3JkZXItc3ByaW5nLTUwIHN1Yi1hdHRyaWJ1dGUtd3JhcHBlclwiPjwvZGl2PicpKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXG4gICAgICAgICAgICAgICAgLnByZXYoJy5zdWJlbGVtZW50JylcbiAgICAgICAgICAgICAgICAuY2hpbGRyZW4oJy53cmFwcGVkLWNoaWxkLWJvZHknKVxuICAgICAgICAgICAgICAgIC5sYXN0KClcbiAgICAgICAgICAgICAgICAuZmluZCgnLnN1Yi1hdHRyaWJ1dGUnKVxuICAgICAgICAgICAgICAgIC53cmFwQWxsKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnPGRpdiBjbGFzcz1cImZvcm0tZmllbGQtZ3JvdXAgZmxleCBmbGV4LXdyYXAgcm91bmRlZC1ici1sZyBib3JkZXIteSBib3JkZXItciBib3JkZXItc3ByaW5nLTUwIHN1Yi1hdHRyaWJ1dGUtd3JhcHBlciBtdC02XCI+PC9kaXY+JykpO1xuICAgICAgICB9XG4gICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldClcbiAgICAgICAgICAgICAgICAucGFyZW50KClcbiAgICAgICAgICAgICAgICAuZmluZCgnLmZvcm0tY2hpbGQtYm9keScpXG4gICAgICAgICAgICAgICAgLmxhc3QoKVxuICAgICAgICAgICAgICAgIC5maW5kKCcuc2VsZWN0MicpXG4gICAgICAgICAgICAgICAgLnNlbGVjdDIoe1xuICAgICAgICAgICAgICAgIHBsYWNlaG9sZGVyOiAnU2VsZWN0IGFuIG9wdGlvbicsXG4gICAgICAgICAgICAgICAgYWxsb3dDbGVhcjogdHJ1ZSxcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2NoaWxkX2NvdW50JywgY291bnQpO1xuICAgICAgICBkeW5hbWljRmllbGQuYWlkVHlwZVZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgZHluYW1pY0ZpZWxkLnNlY3RvclZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICB9O1xuICAgIC8vIGFkZHMgcGFyZW50IGNvbGxlY3Rpb25cbiAgICBGb3JtQnVpbGRlci5wcm90b3R5cGUuYWRkUGFyZW50Rm9ybSA9IGZ1bmN0aW9uIChldikge1xuICAgICAgICBldi5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICB2YXIgdGFyZ2V0ID0gZXYudGFyZ2V0O1xuICAgICAgICB2YXIgY29udGFpbmVyID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignZm9ybV90eXBlJylcbiAgICAgICAgICAgID8gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKFwiLnBhcmVudC1jb2xsZWN0aW9uW2Zvcm1fdHlwZSA9J1wiLmNvbmNhdCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdmb3JtX3R5cGUnKSwgXCInXVwiKSlcbiAgICAgICAgICAgIDogKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcucGFyZW50LWNvbGxlY3Rpb24nKTtcbiAgICAgICAgdmFyIGNvdW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cigncGFyZW50X2NvdW50JylcbiAgICAgICAgICAgID8gcGFyc2VJbnQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cigncGFyZW50X2NvdW50JykpICsgMVxuICAgICAgICAgICAgOiAoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucHJldigpLmZpbmQoJy5tdWx0aS1mb3JtJykubGVuZ3RoXG4gICAgICAgICAgICAgICAgPyAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wcmV2KCkuZmluZCgnLm11bHRpLWZvcm0nKS5sZW5ndGhcbiAgICAgICAgICAgICAgICA6ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLnByZXYoKS5maW5kKCcud3JhcHBlZC1jaGlsZC1ib2R5JykubGVuZ3RoKSArIDE7XG4gICAgICAgIHZhciBwcm90byA9IGNvbnRhaW5lci5kYXRhKCdwcm90b3R5cGUnKS5yZXBsYWNlKC9fX1BBUkVOVF9OQU1FX18vZywgY291bnQpO1xuICAgICAgICBwcm90byA9IHByb3RvLnJlcGxhY2UoL19fTkFNRV9fL2csIDApO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wcmV2KCkuYXBwZW5kKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShwcm90bykpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wcmV2KCkuZmluZCgnLm11bHRpLWZvcm0nKS5sYXN0KCkuZmluZCgnLnNlbGVjdDInKS5zZWxlY3QyKHtcbiAgICAgICAgICAgIHBsYWNlaG9sZGVyOiAnU2VsZWN0IGFuIG9wdGlvbicsXG4gICAgICAgICAgICBhbGxvd0NsZWFyOiB0cnVlLFxuICAgICAgICB9KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldClcbiAgICAgICAgICAgIC5wcmV2KClcbiAgICAgICAgICAgIC5maW5kKCcubXVsdGktZm9ybScpXG4gICAgICAgICAgICAubGFzdCgpXG4gICAgICAgICAgICAuZmluZCgnLmFkZF90b19jb2xsZWN0aW9uJylcbiAgICAgICAgICAgIC5hdHRyKCdwYXJlbnRfY291bnQnLCBjb3VudCk7XG4gICAgICAgIHRoaXMuYWRkV3JhcHBlck9uQWRkKHRhcmdldCk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ3BhcmVudF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgZHluYW1pY0ZpZWxkLmh1bWFuaXRhcmlhblNjb3BlSGlkZVZvY2FidWxhcnlVcmkoKTtcbiAgICAgICAgZHluYW1pY0ZpZWxkLmNvdW50cnlCdWRnZXRIaWRlQ29kZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC5zZWN0b3JWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC5yZWNpcGllbnRWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC5wb2xpY3lWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC50YWdWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC50cmFuc2FjdGlvbkFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC5pbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGRVcmkoKTtcbiAgICB9O1xuICAgIC8vIGRlbGV0ZXMgY29sbGVjdGlvblxuICAgIEZvcm1CdWlsZGVyLnByb3RvdHlwZS5kZWxldGVGb3JtID0gZnVuY3Rpb24gKGV2KSB7XG4gICAgICAgIGV2LnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIHZhciB0YXJnZXQgPSBldi50YXJnZXQ7XG4gICAgICAgIHZhciBjb2xsZWN0aW9uTGVuZ3RoID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcubXVsdGktZm9ybScpLmxlbmd0aFxuICAgICAgICAgICAgPyAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5jbG9zZXN0KCcuc3ViZWxlbWVudCcpLmZpbmQoJy5mb3JtLWNoaWxkLWJvZHknKS5sZW5ndGhcbiAgICAgICAgICAgIDogKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuZm9ybS1jaGlsZC1ib2R5JykubGVuZ3RoO1xuICAgICAgICB2YXIgY291bnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5hZGRfdG9fY29sbGVjdGlvbicpLmF0dHIoJ2NoaWxkX2NvdW50JylcbiAgICAgICAgICAgID8gcGFyc2VJbnQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX2NvbGxlY3Rpb24nKS5hdHRyKCdjaGlsZF9jb3VudCcpKSArIDFcbiAgICAgICAgICAgIDogY29sbGVjdGlvbkxlbmd0aDtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX2NvbGxlY3Rpb24nKS5hdHRyKCdjaGlsZF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgaWYgKGNvbGxlY3Rpb25MZW5ndGggPiAxKSB7XG4gICAgICAgICAgICB2YXIgdGcgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5jbG9zZXN0KCcuZm9ybS1jaGlsZC1ib2R5Jyk7XG4gICAgICAgICAgICB0Zy5uZXh0KCcuZXJyb3InKS5yZW1vdmUoKTtcbiAgICAgICAgICAgIHRnLnJlbW92ZSgpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvLyBkZWxldGVzIHBhcmVudCBjb2xsZWN0aW9uXG4gICAgRm9ybUJ1aWxkZXIucHJvdG90eXBlLmRlbGV0ZVBhcmVudEZvcm0gPSBmdW5jdGlvbiAoZXYpIHtcbiAgICAgICAgZXYucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgdmFyIHRhcmdldCA9IGV2LnRhcmdldDtcbiAgICAgICAgdmFyIGNvbGxlY3Rpb25MZW5ndGggPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5zdWJlbGVtZW50JykubGVuZ3RoO1xuICAgICAgICB2YXIgY291bnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5hZGRfdG9fcGFyZW50JykuYXR0cignY2hpbGRfY291bnQnKVxuICAgICAgICAgICAgPyBwYXJzZUludCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5hZGRfdG9fcGFyZW50JykuYXR0cignY2hpbGRfY291bnQnKSkgKyAxXG4gICAgICAgICAgICA6IGNvbGxlY3Rpb25MZW5ndGg7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmFkZF90b19wYXJlbnQnKS5hdHRyKCdjaGlsZF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX3BhcmVudCcpLmF0dHIoJ3BhcmVudF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgaWYgKGNvbGxlY3Rpb25MZW5ndGggPiAyKSB7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wYXJlbnQoKS5yZW1vdmUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLy9hZGQgd3JhcHBlciBkaXYgYXJvdW5kIHRoZSBhdHRyaWJ1dGVzXG4gICAgRm9ybUJ1aWxkZXIucHJvdG90eXBlLmFkZFdyYXBwZXIgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLm11bHRpLWZvcm0nKS5lYWNoKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKVxuICAgICAgICAgICAgICAgIC5maW5kKCcuYXR0cmlidXRlJylcbiAgICAgICAgICAgICAgICAud3JhcEFsbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJzxkaXYgY2xhc3M9XCJmb3JtLWZpZWxkLWdyb3VwIGZsZXggZmxleC13cmFwIHJvdW5kZWQtYnItbGcgYm9yZGVyLXkgYm9yZGVyLXIgYm9yZGVyLXNwcmluZy01MCBhdHRyaWJ1dGUtd3JhcHBlciBtYi00XCI+PC9kaXY+JykpO1xuICAgICAgICB9KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuc3ViZWxlbWVudCcpXG4gICAgICAgICAgICAuZmluZCgnLndyYXBwZWQtY2hpbGQtYm9keScpXG4gICAgICAgICAgICAuZWFjaChmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcbiAgICAgICAgICAgICAgICAuZmluZCgnLnN1Yi1hdHRyaWJ1dGUnKVxuICAgICAgICAgICAgICAgIC53cmFwQWxsKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnPGRpdiBjbGFzcz1cImZvcm0tZmllbGQtZ3JvdXAgZmxleCBmbGV4LXdyYXAgcm91bmRlZC1ici1sZyBib3JkZXIteSBib3JkZXItciBib3JkZXItc3ByaW5nLTUwIHN1Yi1hdHRyaWJ1dGUtd3JhcHBlciBtYi00XCI+PC9kaXY+JykpO1xuICAgICAgICB9KTtcbiAgICAgICAgdmFyIGZvcm1GaWVsZCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnZm9ybT4uZm9ybS1maWVsZCcpO1xuICAgICAgICBpZiAoZm9ybUZpZWxkLmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIGZvcm1GaWVsZC53cmFwQWxsKCc8ZGl2IGNsYXNzPVwiZm9ybS1maWVsZC1ncm91cC1vdXRlciBncmlkIHhsOmdyaWQtY29scy0yIG1iLTYgLW14LTMgZ2FwLXktNlwiPjwvZGl2PicpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICBGb3JtQnVpbGRlci5wcm90b3R5cGUuYWRkV3JhcHBlck9uQWRkID0gZnVuY3Rpb24gKHRhcmdldCkge1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KVxuICAgICAgICAgICAgLnByZXYoKVxuICAgICAgICAgICAgLmZpbmQoJy5tdWx0aS1mb3JtJylcbiAgICAgICAgICAgIC5sYXN0KClcbiAgICAgICAgICAgIC5maW5kKCcuYXR0cmlidXRlJylcbiAgICAgICAgICAgIC53cmFwQWxsKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnPGRpdiBjbGFzcz1cImZvcm0tZmllbGQtZ3JvdXAgZ3JpZCB4bDpncmlkLWNvbHMtMiByb3VuZGVkLWJyLWxnIGJvcmRlci15IGJvcmRlci1yIGJvcmRlci1zcHJpbmctNTAgYXR0cmlidXRlLXdyYXBwZXIgbWItNFwiPjwvZGl2PicpKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldClcbiAgICAgICAgICAgIC5wcmV2KClcbiAgICAgICAgICAgIC5maW5kKCcubXVsdGktZm9ybScpXG4gICAgICAgICAgICAubGFzdCgpXG4gICAgICAgICAgICAuZmluZCgnLnN1YmVsZW1lbnQnKVxuICAgICAgICAgICAgLmZpbmQoJy53cmFwcGVkLWNoaWxkLWJvZHknKVxuICAgICAgICAgICAgLmVhY2goZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpXG4gICAgICAgICAgICAgICAgLmZpbmQoJy5zdWItYXR0cmlidXRlJylcbiAgICAgICAgICAgICAgICAud3JhcEFsbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJzxkaXYgY2xhc3M9XCJmb3JtLWZpZWxkLWdyb3VwIGZsZXggZmxleC13cmFwIHJvdW5kZWQtYnItbGcgYm9yZGVyLXkgYm9yZGVyLXIgYm9yZGVyLXNwcmluZy01MCBzdWItYXR0cmlidXRlLXdyYXBwZXIgbWItNFwiPjwvZGl2PicpKTtcbiAgICAgICAgfSk7XG4gICAgfTtcbiAgICBGb3JtQnVpbGRlci5wcm90b3R5cGUudGV4dEFyZWFIZWlnaHQgPSBmdW5jdGlvbiAoZXYpIHtcbiAgICAgICAgdmFyIHRhcmdldCA9IGV2LnRhcmdldDtcbiAgICAgICAgdmFyIGhlaWdodCA9IHRhcmdldC5zY3JvbGxIZWlnaHQ7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmNzcygnaGVpZ2h0JywgaGVpZ2h0KTtcbiAgICB9O1xuICAgIEZvcm1CdWlsZGVyLnByb3RvdHlwZS5hZGRUb0NvbGxlY3Rpb24gPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsICcuYWRkX3RvX2NvbGxlY3Rpb24nLCBmdW5jdGlvbiAoZXZlbnQpIHtcbiAgICAgICAgICAgIGlmICgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoZXZlbnQudGFyZ2V0KS5oYXNDbGFzcygnYWRkLWljb24nKSkge1xuICAgICAgICAgICAgICAgIGV2ZW50LnN0b3BQcm9wYWdhdGlvbigpO1xuICAgICAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShldmVudC50YXJnZXQpXG4gICAgICAgICAgICAgICAgICAgIC5wYXJlbnQoJ2J1dHRvbicpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjbGljaycpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZWxzZSB7XG4gICAgICAgICAgICAgICAgX3RoaXMuYWRkRm9ybShldmVudCk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH0pO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5hZGRfdG9fcGFyZW50Jykub24oJ2NsaWNrJywgZnVuY3Rpb24gKGV2ZW50KSB7XG4gICAgICAgICAgICBpZiAoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGV2ZW50LnRhcmdldCkuaGFzQ2xhc3MoJ2FkZC1pY29uJykpIHtcbiAgICAgICAgICAgICAgICBldmVudC5zdG9wUHJvcGFnYXRpb24oKTtcbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoZXZlbnQudGFyZ2V0KVxuICAgICAgICAgICAgICAgICAgICAucGFyZW50KCdidXR0b24nKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2xpY2snKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgICAgIF90aGlzLmFkZFBhcmVudEZvcm0oZXZlbnQpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcbiAgICB9O1xuICAgIEZvcm1CdWlsZGVyLnByb3RvdHlwZS5kZWxldGVDb2xsZWN0aW9uID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuICAgICAgICB2YXIgZGVsZXRlQ29uZmlybWF0aW9uID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuZGVsZXRlLWNvbmZpcm1hdGlvbicpLCBjYW5jZWxQb3B1cCA9ICcuY2FuY2VsLXBvcHVwJywgZGVsZXRlQ29uZmlybSA9ICcuZGVsZXRlLWNvbmZpcm0nO1xuICAgICAgICB2YXIgZGVsZXRlSW5kZXggPSB7fSwgY2hpbGRPclBhcmVudCA9ICcnO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCAnLmRlbGV0ZScsIGZ1bmN0aW9uIChldmVudCkge1xuICAgICAgICAgICAgZGVsZXRlQ29uZmlybWF0aW9uLmZhZGVJbigpO1xuICAgICAgICAgICAgZGVsZXRlSW5kZXggPSBldmVudDtcbiAgICAgICAgICAgIGNoaWxkT3JQYXJlbnQgPSAnY2hpbGQnO1xuICAgICAgICB9KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgY2FuY2VsUG9wdXAsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgIGRlbGV0ZUNvbmZpcm1hdGlvbi5mYWRlT3V0KCk7XG4gICAgICAgICAgICBkZWxldGVJbmRleCA9IHt9O1xuICAgICAgICAgICAgY2hpbGRPclBhcmVudCA9ICcnO1xuICAgICAgICB9KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgZGVsZXRlQ29uZmlybSwgZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgaWYgKGNoaWxkT3JQYXJlbnQgPT09ICdjaGlsZCcpIHtcbiAgICAgICAgICAgICAgICBfdGhpcy5kZWxldGVGb3JtKGRlbGV0ZUluZGV4KTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2UgaWYgKGNoaWxkT3JQYXJlbnQgPT09ICdwYXJlbnQnKSB7XG4gICAgICAgICAgICAgICAgX3RoaXMuZGVsZXRlUGFyZW50Rm9ybShkZWxldGVJbmRleCk7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBkZWxldGVDb25maXJtYXRpb24uZmFkZU91dCgpO1xuICAgICAgICAgICAgZGVsZXRlSW5kZXggPSB7fTtcbiAgICAgICAgICAgIGNoaWxkT3JQYXJlbnQgPSAnJztcbiAgICAgICAgfSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsICcuZGVsZXRlLXBhcmVudCcsIGZ1bmN0aW9uIChldmVudCkge1xuICAgICAgICAgICAgZGVsZXRlQ29uZmlybWF0aW9uLmZhZGVJbigpO1xuICAgICAgICAgICAgZGVsZXRlSW5kZXggPSBldmVudDtcbiAgICAgICAgICAgIGNoaWxkT3JQYXJlbnQgPSAncGFyZW50JztcbiAgICAgICAgfSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLnNlbGVjdDInKS5zZWxlY3QyKHtcbiAgICAgICAgICAgIHBsYWNlaG9sZGVyOiAnU2VsZWN0IGFuIG9wdGlvbicsXG4gICAgICAgICAgICBhbGxvd0NsZWFyOiB0cnVlLFxuICAgICAgICB9KTtcbiAgICAgICAgLy8gdXBkYXRlIGZvcm1hdCBvbiBjaGFuZ2Ugb2YgZG9jdW1lbnQgbGlua1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbigna2V5dXAnLCAnaW5wdXRbaWQqPVwiW3VybF1cIl0nLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuICAgICAgICAgICAgdmFyIF9hO1xuICAgICAgICAgICAgdmFyIGZpbGVQYXRoID0gKChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJycpLnRvU3RyaW5nKCk7XG4gICAgICAgICAgICB2YXIgdXJsID0gXCIvbWltZXR5cGU/dXJsPVwiLmNvbmNhdChmaWxlUGF0aCwgXCImdHlwZT11cmxcIik7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykuY2xvc2VzdCgnLmZvcm0tZmllbGQnKS5maW5kKCcudGV4dC1kYW5nZXInKS5yZW1vdmUoKTtcbiAgICAgICAgICAgIGlmIChmaWxlUGF0aCAhPT0gJycpIHtcbiAgICAgICAgICAgICAgICBheGlvc18xLmRlZmF1bHQuZ2V0KHVybCkudGhlbihmdW5jdGlvbiAocmVzcG9uc2UpIHtcbiAgICAgICAgICAgICAgICAgICAgaWYgKHJlc3BvbnNlLmRhdGEuc3VjY2Vzcykge1xuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGZvcm1hdCA9IHJlc3BvbnNlLmRhdGEuZGF0YS5taW1ldHlwZTtcbiAgICAgICAgICAgICAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShfdGhpcylcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC5maW5kKCdzZWxlY3RbaWQqPVwiW2Zvcm1hdF1cIl0nKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC52YWwoZm9ybWF0KVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBtZXNzYWdlID0gXCI8ZGl2IGNsYXNzPSd0ZXh0LWRhbmdlciBlcnJvcic+XCIgKyByZXNwb25zZS5kYXRhLm1lc3NhZ2UgKyBcIjwvZGl2PlwiO1xuICAgICAgICAgICAgICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKF90aGlzKS5jbG9zZXN0KCcuZm9ybS1maWVsZCcpLmFwcGVuZChcIjxkaXYgY2xhc3M9J3RleHQtZGFuZ2VyIGVycm9yJz5cIiArIHJlc3BvbnNlLmRhdGEubWVzc2FnZSArIFwiPC9kaXY+XCIpO1xuICAgICAgICAgICAgICAgICAgICAgICAgY29uc29sZS5sb2cobWVzc2FnZSk7XG4gICAgICAgICAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoX3RoaXMpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAuZmluZCgnc2VsZWN0W2lkKj1cIltmb3JtYXRdXCJdJylcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZCgnaW5wdXRbaWQqPVwiW2RvY3VtZW50XVwiXScpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjaGFuZ2UnLCAnaW5wdXRbaWQqPVwiW2RvY3VtZW50XVwiXScsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICBjb25zb2xlLmxvZygnY2hhbmdlZCcpO1xuICAgICAgICAgICAgdmFyIGZpbGVQYXRoID0gKChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJycpLnRvU3RyaW5nKCk7XG4gICAgICAgICAgICB2YXIgdXJsID0gXCIvbWltZXR5cGU/dXJsPVwiLmNvbmNhdChmaWxlUGF0aCwgXCImJnR5cGU9ZG9jdW1lbnRcIik7XG4gICAgICAgICAgICBpZiAoZmlsZVBhdGggIT09ICcnKSB7XG4gICAgICAgICAgICAgICAgYXhpb3NfMS5kZWZhdWx0LmdldCh1cmwpLnRoZW4oZnVuY3Rpb24gKHJlc3BvbnNlKSB7XG4gICAgICAgICAgICAgICAgICAgIGlmIChyZXNwb25zZS5kYXRhLnN1Y2Nlc3MpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBmb3JtYXQgPSByZXNwb25zZS5kYXRhLmRhdGEubWltZXR5cGU7XG4gICAgICAgICAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoX3RoaXMpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAuZmluZCgnc2VsZWN0W2lkKj1cIltmb3JtYXRdXCJdJylcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAudmFsKGZvcm1hdClcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJyk7XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgZWxzZSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoX3RoaXMpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAuZmluZCgnc2VsZWN0W2lkKj1cIltmb3JtYXRdXCJdJylcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZCgnaW5wdXRbaWQqPVwiW3VybF1cIl0nKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJyk7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKVxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgLmZpbmQoJ3NlbGVjdFtpZCo9XCJbZm9ybWF0XVwiXScpXG4gICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJyk7XG4gICAgICAgIH0pO1xuICAgIH07XG4gICAgcmV0dXJuIEZvcm1CdWlsZGVyO1xufSgpKTtcbigwLCBqcXVlcnlfMS5kZWZhdWx0KShmdW5jdGlvbiAoKSB7XG4gICAgdmFyIGZvcm1CdWlsZGVyID0gbmV3IEZvcm1CdWlsZGVyKCk7XG4gICAgZm9ybUJ1aWxkZXIuYWRkV3JhcHBlcigpO1xuICAgIGR5bmFtaWNGaWVsZC5oaWRlU2hvd0Zvcm1GaWVsZHMoKTtcbiAgICBkeW5hbWljRmllbGQudXBkYXRlQWN0aXZpdHlJZGVudGlmaWVyKCk7XG4gICAgZm9ybUJ1aWxkZXIuYWRkVG9Db2xsZWN0aW9uKCk7XG4gICAgZm9ybUJ1aWxkZXIuZGVsZXRlQ29sbGVjdGlvbigpO1xuICAgIC8qKlxuICAgICAqIFRleHQgYXJlYSBoZWlnaHQgb24gdHlwaW5nXG4gICAgICovXG4gICAgdmFyIHRleHRBcmVhVGFyZ2V0ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCd0ZXh0YXJlYS5mb3JtX19pbnB1dCcpO1xuICAgIGlmICh0ZXh0QXJlYVRhcmdldC5sZW5ndGggPiAwKSB7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdpbnB1dCcsICd0ZXh0YXJlYS5mb3JtX19pbnB1dCcsIGZ1bmN0aW9uIChldmVudCkge1xuICAgICAgICAgICAgZm9ybUJ1aWxkZXIudGV4dEFyZWFIZWlnaHQoZXZlbnQpO1xuICAgICAgICB9KTtcbiAgICB9XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ3NlbGVjdDI6b3BlbicsICcuc2VsZWN0MicsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIHNlbGVjdF9zZWFyY2ggPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcuc2VsZWN0Mi1zZWFyY2hfX2ZpZWxkJyk7XG4gICAgICAgIGlmIChzZWxlY3Rfc2VhcmNoKSB7XG4gICAgICAgICAgICBzZWxlY3Rfc2VhcmNoLmZvY3VzKCk7XG4gICAgICAgIH1cbiAgICB9KTtcbiAgICAvKipcbiAgICAgKiBjaGVja3MgcmVnaXN0cmF0aW9uIGFnZW5jeSwgY291bnRyeSBhbmQgcmVnaXN0cmF0aW9uIG51bWJlciB0byBkZWR1Y2UgaWRlbnRpZmllclxuICAgICAqL1xuICAgIHVwZGF0ZVJlZ2lzdHJhdGlvbkFnZW5jeSgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbml6YXRpb25fY291bnRyeScpKTtcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbmlzYXRpb25faWRlbnRpZmllcicpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJyk7XG4gICAgZnVuY3Rpb24gdXBkYXRlUmVnaXN0cmF0aW9uQWdlbmN5KGNvdW50cnkpIHtcbiAgICAgICAgaWYgKGNvdW50cnkudmFsKCkpIHtcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuYWpheCh7IHVybDogJy9vcmdhbmlzYXRpb24vYWdlbmN5LycgKyBjb3VudHJ5LnZhbCgpIH0pLnRoZW4oZnVuY3Rpb24gKHJlc3BvbnNlKSB7XG4gICAgICAgICAgICAgICAgdmFyIF9hO1xuICAgICAgICAgICAgICAgIHZhciBjdXJyZW50X3ZhbCA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI29yZ2FuaXphdGlvbl9yZWdpc3RyYXRpb25fYWdlbmN5JykudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcnO1xuICAgICAgICAgICAgICAgIHZhciB2YWwgPSBmYWxzZTtcbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScpLmVtcHR5KCk7XG4gICAgICAgICAgICAgICAgZm9yICh2YXIgZGF0YSBpbiByZXNwb25zZS5kYXRhKSB7XG4gICAgICAgICAgICAgICAgICAgIGlmIChkYXRhID09PSBjdXJyZW50X3ZhbCkge1xuICAgICAgICAgICAgICAgICAgICAgICAgdmFsID0gdHJ1ZTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScpXG4gICAgICAgICAgICAgICAgICAgICAgICAuYXBwZW5kKG5ldyBPcHRpb24ocmVzcG9uc2UuZGF0YVtkYXRhXSwgZGF0YSwgdHJ1ZSwgdHJ1ZSkpXG4gICAgICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScpXG4gICAgICAgICAgICAgICAgICAgIC52YWwodmFsID8gY3VycmVudF92YWwgOiAnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ3NlbGVjdDI6c2VsZWN0JywgJyNvcmdhbml6YXRpb25fY291bnRyeScsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdXBkYXRlUmVnaXN0cmF0aW9uQWdlbmN5KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKSk7XG4gICAgfSk7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ3NlbGVjdDI6c2VsZWN0JywgJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIGlkZW50aWZpZXIgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykudmFsKCkgKyAnLScgKyAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNyZWdpc3RyYXRpb25fbnVtYmVyJykudmFsKCk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI29yZ2FuaXNhdGlvbl9pZGVudGlmaWVyJykudmFsKGlkZW50aWZpZXIpO1xuICAgIH0pO1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdzZWxlY3QyOmNsZWFyJywgJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIGlkZW50aWZpZXIgPSAnLScgKyAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNyZWdpc3RyYXRpb25fbnVtYmVyJykudmFsKCk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI29yZ2FuaXNhdGlvbl9pZGVudGlmaWVyJykudmFsKGlkZW50aWZpZXIpO1xuICAgIH0pO1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdrZXl1cCcsICcjcmVnaXN0cmF0aW9uX251bWJlcicsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIGlkZW50aWZpZXIgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScpLnZhbCgpICsgJy0nICsgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpLnZhbCgpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbmlzYXRpb25faWRlbnRpZmllcicpLnZhbChpZGVudGlmaWVyKTtcbiAgICB9KTtcbiAgICAvLyBhZGQgY2xhc3MgdG8gdGl0bGUgb2YgY29sbGVjdGlvbiB3aGVuIHZhbGlkYXRpb24gZXJyb3Igb2NjdXJzIG9uIGNvbGxlY3Rpb24gbGV2ZWxcbiAgICB2YXIgc3ViZWxlbWVudCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJy5zdWJlbGVtZW50Jyk7XG4gICAgZm9yICh2YXIgaSA9IDA7IGkgPCBzdWJlbGVtZW50Lmxlbmd0aDsgaSsrKSB7XG4gICAgICAgIHZhciB0aXRsZSA9IHN1YmVsZW1lbnRbaV0ucXVlcnlTZWxlY3RvcignLmNvbnRyb2wtbGFiZWwnKTtcbiAgICAgICAgdmFyIGVycm9yQ29udGFpbmVyID0gc3ViZWxlbWVudFtpXS5xdWVyeVNlbGVjdG9yKCcuY29sbGVjdGlvbl9lcnJvcicpO1xuICAgICAgICB2YXIgY2hpbGRDb3VudCA9IGVycm9yQ29udGFpbmVyID09PSBudWxsIHx8IGVycm9yQ29udGFpbmVyID09PSB2b2lkIDAgPyB2b2lkIDAgOiBlcnJvckNvbnRhaW5lci5jaGlsZEVsZW1lbnRDb3VudDtcbiAgICAgICAgaWYgKGNoaWxkQ291bnQgJiYgY2hpbGRDb3VudCA+IDApIHtcbiAgICAgICAgICAgIHRpdGxlID09PSBudWxsIHx8IHRpdGxlID09PSB2b2lkIDAgPyB2b2lkIDAgOiB0aXRsZS5jbGFzc0xpc3QuYWRkKCdlcnJvci10aXRsZScpO1xuICAgICAgICB9XG4gICAgfVxuICAgIC8vIEFkZGluZyBjdXJzb3Igbm90IGFsbG93ZWQgdG8gPHNlbGVjdD4gd2hlcmUgZWxlbWVudEpzb25TY2hlbWEgcmVhZF9vbmx5IDogdHJ1ZVxuICAgIHZhciByZWFkT25seVNlbGVjdHMgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCdzZWxlY3QuY3Vyc29yLW5vdC1hbGxvd2VkJyk7XG4gICAgZm9yICh2YXIgaSA9IDA7IGkgPCByZWFkT25seVNlbGVjdHMubGVuZ3RoOyBpKyspIHtcbiAgICAgICAgdmFyIHNlbGVjdCA9IHJlYWRPbmx5U2VsZWN0c1tpXTtcbiAgICAgICAgdmFyIHNlbGVjdEVsZW1lbnRQYXJlbnRXcmFwcGVyID0gc2VsZWN0Lm5leHRTaWJsaW5nO1xuICAgICAgICB2YXIgc2VsZWN0RWxlbWVudFBhcmVudCA9IHNlbGVjdEVsZW1lbnRQYXJlbnRXcmFwcGVyID09PSBudWxsIHx8IHNlbGVjdEVsZW1lbnRQYXJlbnRXcmFwcGVyID09PSB2b2lkIDAgPyB2b2lkIDAgOiBzZWxlY3RFbGVtZW50UGFyZW50V3JhcHBlci5maXJzdENoaWxkO1xuICAgICAgICB2YXIgc2VsZWN0RWxlbWVudCA9IHNlbGVjdEVsZW1lbnRQYXJlbnQgPT09IG51bGwgfHwgc2VsZWN0RWxlbWVudFBhcmVudCA9PT0gdm9pZCAwID8gdm9pZCAwIDogc2VsZWN0RWxlbWVudFBhcmVudC5maXJzdENoaWxkO1xuICAgICAgICBpZiAoc2VsZWN0RWxlbWVudCkge1xuICAgICAgICAgICAgc2VsZWN0RWxlbWVudC5zdHlsZS5jdXJzb3IgPSAnbm90LWFsbG93ZWQnO1xuICAgICAgICB9XG4gICAgfVxufSk7XG4iXSwibmFtZXMiOlsiX19pbXBvcnREZWZhdWx0IiwibW9kIiwiX19lc01vZHVsZSIsIk9iamVjdCIsImRlZmluZVByb3BlcnR5IiwiZXhwb3J0cyIsInZhbHVlIiwiRHluYW1pY0ZpZWxkIiwianF1ZXJ5XzEiLCJyZXF1aXJlIiwicHJvdG90eXBlIiwiaGlkZVNob3dGb3JtRmllbGRzIiwiaHVtYW5pdGFyaWFuU2NvcGVIaWRlVm9jYWJ1bGFyeVVyaSIsImNvdW50cnlCdWRnZXRIaWRlQ29kZUZpZWxkIiwiYWlkVHlwZVZvY2FidWxhcnlIaWRlRmllbGQiLCJzZWN0b3JWb2NhYnVsYXJ5SGlkZUZpZWxkIiwicG9saWN5Vm9jYWJ1bGFyeUhpZGVGaWVsZCIsInJlY2lwaWVudFZvY2FidWxhcnlIaWRlRmllbGQiLCJ0YWdWb2NhYnVsYXJ5SGlkZUZpZWxkIiwidHJhbnNhY3Rpb25BaWRUeXBlVm9jYWJ1bGFyeUhpZGVGaWVsZCIsImluZGljYXRvclJlZmVyZW5jZUhpZGVGaWVsZFVyaSIsIl90aGlzIiwiaHVtYW5pdGFyaWFuU2NvcGVWb2NhYnVsYXJ5IiwibGVuZ3RoIiwiZWFjaCIsImluZGV4Iiwic2NvcGUiLCJfYSIsInZhbCIsImhpZGVIdW1hbml0YXJpYW5TY29wZUZpZWxkIiwidG9TdHJpbmciLCJvbiIsImUiLCJwYXJhbXMiLCJkYXRhIiwiaWQiLCJ0YXJnZXQiLCJjbG9zZXN0IiwiZmluZCIsInNob3ciLCJyZW1vdmVBdHRyIiwidHJpZ2dlciIsImhpZGUiLCJhdHRyIiwicmVmZXJlbmNlVm9jYWJ1bGFyeSIsImluZGljYXRvclJlZmVyZW5jZUhpZGVGaWVsZCIsInJlZmVyZW5jZVVyaSIsImNvdW50cnlCdWRnZXRWb2NhYnVsYXJ5IiwiaGlkZUNvdW50cnlCdWRnZXRGaWVsZCIsImNvdW50cnlCdWRnZXRDb2RlSW5wdXQiLCJjb3VudHJ5QnVkZ2V0Q29kZVNlbGVjdCIsImFpZHR5cGVfdm9jYWJ1bGFyeSIsIml0ZW0iLCJoaWRlQWlkVHlwZVNlbGVjdEZpZWxkIiwiaGlkZVRyYW5zYWN0aW9uQWlkVHlwZVNlbGVjdEZpZWxkIiwiZGVmYXVsdF9haWRfdHlwZSIsImVhcm1hcmtpbmdfY2F0ZWdvcnkiLCJlYXJtYXJraW5nX21vZGFsaXR5IiwiY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzIiwiY2FzZTEiLCJjYXNlMiIsImNhc2UzIiwiY2FzZTQiLCJhaWRfdHlwZSIsInBvbGljeW1ha2VyX3ZvY2FidWxhcnkiLCJwb2xpY3lfbWFya2VyIiwiaGlkZVBvbGljeU1ha2VyRmllbGQiLCJjYXNlMV9zaG93IiwiY2FzZTJfc2hvdyIsInNlY3Rvcl92b2NhYnVsYXJ5Iiwic2VjdG9yIiwiaGlkZVNlY3RvckZpZWxkIiwiY2FzZTdfc2hvdyIsImNhc2U4X3Nob3ciLCJjYXNlOThfOTlfc2hvdyIsImRlZmF1bHRfc2hvdyIsImNhc2U3IiwiY2FzZTgiLCJjYXNlOThfOTkiLCJkZWZhdWx0X2hpZGUiLCJyZWdpb25fdm9jYWJ1bGFyeSIsInJlZ2lvbl92b2NhYiIsImhpZGVSZWNpcGllbnRSZWdpb25GaWVsZCIsImNhc2U5OV9zaG93IiwiY2FzZTk5IiwidXBkYXRlQWN0aXZpdHlJZGVudGlmaWVyIiwiYWN0aXZpdHlfaWRlbnRpZmllciIsImNvbmNhdCIsInRhZ192b2NhYnVsYXJ5IiwidGFnIiwiaGlkZVRhZ0ZpZWxkIiwiY2FzZTNfc2hvdyIsImF4aW9zXzEiLCJEeW5hbWljRmllbGRfMSIsImR5bmFtaWNGaWVsZCIsIkZvcm1CdWlsZGVyIiwiYWRkRm9ybSIsImV2IiwicHJldmVudERlZmF1bHQiLCJjb250YWluZXIiLCJjb3VudCIsInBhcnNlSW50IiwicGFyZW50IiwicGFyZW50X2NvdW50IiwicGFyZW50cyIsIndyYXBwZXJfcGFyZW50X2NvdW50IiwicHJvdG8iLCJyZXBsYWNlIiwicHJldiIsImFwcGVuZCIsImNoaWxkcmVuIiwibGFzdCIsInNlbGVjdDIiLCJwbGFjZWhvbGRlciIsImFsbG93Q2xlYXIiLCJ3cmFwQWxsIiwiYWRkUGFyZW50Rm9ybSIsImFkZFdyYXBwZXJPbkFkZCIsImRlbGV0ZUZvcm0iLCJjb2xsZWN0aW9uTGVuZ3RoIiwidGciLCJuZXh0IiwicmVtb3ZlIiwiZGVsZXRlUGFyZW50Rm9ybSIsImFkZFdyYXBwZXIiLCJmb3JtRmllbGQiLCJ0ZXh0QXJlYUhlaWdodCIsImhlaWdodCIsInNjcm9sbEhlaWdodCIsImNzcyIsImFkZFRvQ29sbGVjdGlvbiIsImV2ZW50IiwiaGFzQ2xhc3MiLCJzdG9wUHJvcGFnYXRpb24iLCJkZWxldGVDb2xsZWN0aW9uIiwiZGVsZXRlQ29uZmlybWF0aW9uIiwiY2FuY2VsUG9wdXAiLCJkZWxldGVDb25maXJtIiwiZGVsZXRlSW5kZXgiLCJjaGlsZE9yUGFyZW50IiwiZmFkZUluIiwiZmFkZU91dCIsImZpbGVQYXRoIiwidXJsIiwiZ2V0IiwidGhlbiIsInJlc3BvbnNlIiwic3VjY2VzcyIsImZvcm1hdCIsIm1pbWV0eXBlIiwibWVzc2FnZSIsImNvbnNvbGUiLCJsb2ciLCJmb3JtQnVpbGRlciIsInRleHRBcmVhVGFyZ2V0Iiwic2VsZWN0X3NlYXJjaCIsImRvY3VtZW50IiwicXVlcnlTZWxlY3RvciIsImZvY3VzIiwidXBkYXRlUmVnaXN0cmF0aW9uQWdlbmN5IiwiY291bnRyeSIsImFqYXgiLCJjdXJyZW50X3ZhbCIsImVtcHR5IiwiT3B0aW9uIiwiaWRlbnRpZmllciIsInN1YmVsZW1lbnQiLCJxdWVyeVNlbGVjdG9yQWxsIiwiaSIsInRpdGxlIiwiZXJyb3JDb250YWluZXIiLCJjaGlsZENvdW50IiwiY2hpbGRFbGVtZW50Q291bnQiLCJjbGFzc0xpc3QiLCJhZGQiLCJyZWFkT25seVNlbGVjdHMiLCJzZWxlY3QiLCJzZWxlY3RFbGVtZW50UGFyZW50V3JhcHBlciIsIm5leHRTaWJsaW5nIiwic2VsZWN0RWxlbWVudFBhcmVudCIsImZpcnN0Q2hpbGQiLCJzZWxlY3RFbGVtZW50Iiwic3R5bGUiLCJjdXJzb3IiXSwic291cmNlUm9vdCI6IiJ9
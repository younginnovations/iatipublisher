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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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Q0F6RTZCLENBMEU5Qjs7O0VBQ0EsSUFBSUMsZUFBZSxHQUFHdEIsUUFBUSxDQUFDYyxnQkFBVCxDQUEwQiwyQkFBMUIsQ0FBdEI7O0VBQ0EsS0FBSyxJQUFJQyxDQUFDLEdBQUcsQ0FBYixFQUFnQkEsQ0FBQyxHQUFHTyxlQUFlLENBQUNySixNQUFwQyxFQUE0QzhJLENBQUMsRUFBN0MsRUFBaUQ7SUFDN0MsSUFBSVEsTUFBTSxHQUFHRCxlQUFlLENBQUNQLENBQUQsQ0FBNUI7SUFDQSxJQUFJUywwQkFBMEIsR0FBR0QsTUFBTSxDQUFDRSxXQUF4QztJQUNBLElBQUlDLG1CQUFtQixHQUFHRiwwQkFBMEIsS0FBSyxJQUEvQixJQUF1Q0EsMEJBQTBCLEtBQUssS0FBSyxDQUEzRSxHQUErRSxLQUFLLENBQXBGLEdBQXdGQSwwQkFBMEIsQ0FBQ0csVUFBN0k7SUFDQSxJQUFJQyxhQUFhLEdBQUdGLG1CQUFtQixLQUFLLElBQXhCLElBQWdDQSxtQkFBbUIsS0FBSyxLQUFLLENBQTdELEdBQWlFLEtBQUssQ0FBdEUsR0FBMEVBLG1CQUFtQixDQUFDQyxVQUFsSDs7SUFDQSxJQUFJQyxhQUFKLEVBQW1CO01BQ2ZBLGFBQWEsQ0FBQ0MsS0FBZCxDQUFvQkMsTUFBcEIsR0FBNkIsYUFBN0I7SUFDSDtFQUNKO0FBQ0osQ0FyRkQiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2pzL3NjcmlwdHMvRHluYW1pY0ZpZWxkLnRzIiwid2VicGFjazovLy8uL3Jlc291cmNlcy9hc3NldHMvanMvc2NyaXB0cy9mb3JtYnVpbGRlci50cyJdLCJzb3VyY2VzQ29udGVudCI6WyJcInVzZSBzdHJpY3RcIjtcbnZhciBfX2ltcG9ydERlZmF1bHQgPSAodGhpcyAmJiB0aGlzLl9faW1wb3J0RGVmYXVsdCkgfHwgZnVuY3Rpb24gKG1vZCkge1xuICAgIHJldHVybiAobW9kICYmIG1vZC5fX2VzTW9kdWxlKSA/IG1vZCA6IHsgXCJkZWZhdWx0XCI6IG1vZCB9O1xufTtcbk9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBcIl9fZXNNb2R1bGVcIiwgeyB2YWx1ZTogdHJ1ZSB9KTtcbmV4cG9ydHMuRHluYW1pY0ZpZWxkID0gdm9pZCAwO1xudmFyIGpxdWVyeV8xID0gX19pbXBvcnREZWZhdWx0KHJlcXVpcmUoXCJqcXVlcnlcIikpO1xucmVxdWlyZShcInNlbGVjdDJcIik7XG52YXIgRHluYW1pY0ZpZWxkID0gLyoqIEBjbGFzcyAqLyAoZnVuY3Rpb24gKCkge1xuICAgIGZ1bmN0aW9uIER5bmFtaWNGaWVsZCgpIHtcbiAgICB9XG4gICAgLyoqXG4gICAgICogSGlkZSBhbmQgU2hvdyBkaWZmZXJlbnQgZm9ybSBmaWVsZHMgYmFzZWQgb24gdm9jYWJ1bGFyeSBhbmQgb3RoZXIgdHlwZXNcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmhpZGVTaG93Rm9ybUZpZWxkcyA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdGhpcy5odW1hbml0YXJpYW5TY29wZUhpZGVWb2NhYnVsYXJ5VXJpKCk7XG4gICAgICAgIHRoaXMuY291bnRyeUJ1ZGdldEhpZGVDb2RlRmllbGQoKTtcbiAgICAgICAgdGhpcy5haWRUeXBlVm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICB0aGlzLnNlY3RvclZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgdGhpcy5wb2xpY3lWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIHRoaXMucmVjaXBpZW50Vm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICB0aGlzLnNlY3RvclZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgdGhpcy50YWdWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIHRoaXMudHJhbnNhY3Rpb25BaWRUeXBlVm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICB0aGlzLmluZGljYXRvclJlZmVyZW5jZUhpZGVGaWVsZFVyaSgpO1xuICAgIH07XG4gICAgLyoqXG4gICAgICogSHVtYW5pdGFyaWFuIFNjb3BlIEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaHVtYW5pdGFyaWFuU2NvcGVIaWRlVm9jYWJ1bGFyeVVyaSA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgdmFyIGh1bWFuaXRhcmlhblNjb3BlVm9jYWJ1bGFyeSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnc2VsZWN0W2lkXj1cImh1bWFuaXRhcmlhbl9zY29wZVwiXVtpZCo9XCJbdm9jYWJ1bGFyeV1cIl0nKTtcbiAgICAgICAgaWYgKGh1bWFuaXRhcmlhblNjb3BlVm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICAvLyBoaWRlIGZpZWxkcyBvbiBwYWdlIGxvYWRcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuZWFjaChodW1hbml0YXJpYW5TY29wZVZvY2FidWxhcnksIGZ1bmN0aW9uIChpbmRleCwgc2NvcGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICAgICAgdmFyIHZhbCA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShzY29wZSkudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcnO1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVIdW1hbml0YXJpYW5TY29wZUZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShzY29wZSksIHZhbC50b1N0cmluZygpKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgLy8gaGlkZS9zaG93IGZpZWxkcyBvbiB2YWx1ZSBjaGFuZ2VcbiAgICAgICAgICAgIGh1bWFuaXRhcmlhblNjb3BlVm9jYWJ1bGFyeS5vbignc2VsZWN0MjpzZWxlY3QnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciB2YWwgPSBlLnBhcmFtcy5kYXRhLmlkO1xuICAgICAgICAgICAgICAgIHZhciBpbmRleCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVIdW1hbml0YXJpYW5TY29wZUZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShpbmRleCksIHZhbCk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIC8vIGhpZGUvc2hvdyBmaWVsZHMgb24gdmFsdWUgY2xlYXJcbiAgICAgICAgICAgIGh1bWFuaXRhcmlhblNjb3BlVm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIGluZGV4ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZUh1bWFuaXRhcmlhblNjb3BlRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGluZGV4KSwgJycpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8vIGhpZGUgY291bnRyeSBidWRnZXQgYmFzZWQgb24gdm9jYWJ1bGFyeVxuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaGlkZUh1bWFuaXRhcmlhblNjb3BlRmllbGQgPSBmdW5jdGlvbiAoaW5kZXgsIHZhbHVlKSB7XG4gICAgICAgIHZhciBodW1hbml0YXJpYW5TY29wZUhpZGVWb2NhYnVsYXJ5VXJpID0gJ2lucHV0W2lkXj1cImh1bWFuaXRhcmlhbl9zY29wZVwiXVtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdJztcbiAgICAgICAgaWYgKHZhbHVlID09PSAnOTknKSB7XG4gICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgLmZpbmQoaHVtYW5pdGFyaWFuU2NvcGVIaWRlVm9jYWJ1bGFyeVVyaSlcbiAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgIH1cbiAgICAgICAgZWxzZSB7XG4gICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgLmZpbmQoaHVtYW5pdGFyaWFuU2NvcGVIaWRlVm9jYWJ1bGFyeVVyaSlcbiAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAqIEh1bWFuaXRhcmlhbiBTY29wZSBGb3JtIFBhZ2VcbiAgICpcbiAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmluZGljYXRvclJlZmVyZW5jZUhpZGVGaWVsZFVyaSA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgdmFyIHJlZmVyZW5jZVZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdFtpZF49XCJyZWZlcmVuY2VcIl1baWQqPVwiW3ZvY2FidWxhcnldXCJdJyk7XG4gICAgICAgIGlmIChyZWZlcmVuY2VWb2NhYnVsYXJ5Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIC8vIGhpZGUgZmllbGRzIG9uIHBhZ2UgbG9hZFxuICAgICAgICAgICAganF1ZXJ5XzEuZGVmYXVsdC5lYWNoKHJlZmVyZW5jZVZvY2FidWxhcnksIGZ1bmN0aW9uIChpbmRleCwgc2NvcGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICAgICAgdmFyIHZhbCA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShzY29wZSkudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcnO1xuICAgICAgICAgICAgICAgIF90aGlzLmluZGljYXRvclJlZmVyZW5jZUhpZGVGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoc2NvcGUpLCB2YWwudG9TdHJpbmcoKSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIC8vIGhpZGUvc2hvdyBmaWVsZHMgb24gdmFsdWUgY2hhbmdlXG4gICAgICAgICAgICByZWZlcmVuY2VWb2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOnNlbGVjdCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIHZhbCA9IGUucGFyYW1zLmRhdGEuaWQ7XG4gICAgICAgICAgICAgICAgdmFyIGluZGV4ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShpbmRleCksIHZhbCk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIC8vIGhpZGUvc2hvdyBmaWVsZHMgb24gdmFsdWUgY2xlYXJcbiAgICAgICAgICAgIHJlZmVyZW5jZVZvY2FidWxhcnkub24oJ3NlbGVjdDI6Y2xlYXInLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciBpbmRleCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmluZGljYXRvclJlZmVyZW5jZUhpZGVGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaW5kZXgpLCAnJyk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLy8gaGlkZSBjb3VudHJ5IGJ1ZGdldCBiYXNlZCBvbiB2b2NhYnVsYXJ5XG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5pbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGQgPSBmdW5jdGlvbiAoaW5kZXgsIHZhbHVlKSB7XG4gICAgICAgIHZhciByZWZlcmVuY2VVcmkgPSAnaW5wdXRbaWRePVwicmVmZXJlbmNlXCJdW2lkKj1cIltpbmRpY2F0b3JfdXJpXVwiXSc7XG4gICAgICAgIGlmICh2YWx1ZSA9PT0gJzk5Jykge1xuICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgIC5maW5kKHJlZmVyZW5jZVVyaSlcbiAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgIH1cbiAgICAgICAgZWxzZSB7XG4gICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgLmZpbmQocmVmZXJlbmNlVXJpKVxuICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBDb3VudHJ5IEJ1ZGdldCBGb3JtIFBhZ2VcbiAgICAgKlxuICAgICAqIEBMb2dpYyBzaG93L2hpZGUgJ2NvZGUnIGZpZWxkIGJhc2VkIG9uICdAdm9jYWJ1bGFyeScgZmllbGQgdmFsdWVcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmNvdW50cnlCdWRnZXRIaWRlQ29kZUZpZWxkID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuICAgICAgICB2YXIgX2E7XG4gICAgICAgIHZhciBjb3VudHJ5QnVkZ2V0Vm9jYWJ1bGFyeSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnc2VsZWN0I2NvdW50cnlfYnVkZ2V0X3ZvY2FidWxhcnknKTtcbiAgICAgICAgaWYgKGNvdW50cnlCdWRnZXRWb2NhYnVsYXJ5Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIC8vIGhpZGUvc2hvdyBvbiBwYWdlIGxvYWRcbiAgICAgICAgICAgIHZhciB2YWwgPSAoX2EgPSBjb3VudHJ5QnVkZ2V0Vm9jYWJ1bGFyeS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJzEnO1xuICAgICAgICAgICAgdGhpcy5oaWRlQ291bnRyeUJ1ZGdldEZpZWxkKHZhbC50b1N0cmluZygpKTtcbiAgICAgICAgICAgIC8vIGhpZGUvc2hvdyBvbiB2YWx1ZSBjaGFuZ2VcbiAgICAgICAgICAgIGNvdW50cnlCdWRnZXRWb2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOnNlbGVjdCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIHZhbCA9IGUucGFyYW1zLmRhdGEuaWQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZUNvdW50cnlCdWRnZXRGaWVsZCh2YWwpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAvL2hpZGUvc2hvdyBiYXNlZCBvbiB2YWx1ZSBjbGVhcmVkXG4gICAgICAgICAgICBjb3VudHJ5QnVkZ2V0Vm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlQ291bnRyeUJ1ZGdldEZpZWxkKCcnKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBIaWRlIENvdW50cnkgQnVkZ2V0IEZpZWxkc1xuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaGlkZUNvdW50cnlCdWRnZXRGaWVsZCA9IGZ1bmN0aW9uICh2YWx1ZSkge1xuICAgICAgICB2YXIgY291bnRyeUJ1ZGdldENvZGVJbnB1dCA9ICdpbnB1dFtpZF49XCJidWRnZXRfaXRlbVwiXVtpZCo9XCJbY29kZV90ZXh0XVwiXScsIGNvdW50cnlCdWRnZXRDb2RlU2VsZWN0ID0gJ3NlbGVjdFtpZF49XCJidWRnZXRfaXRlbVwiXVtpZCo9XCJbY29kZV1cIl0nO1xuICAgICAgICBpZiAodmFsdWUgPT09ICcxJykge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGNvdW50cnlCdWRnZXRDb2RlU2VsZWN0KVxuICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoY291bnRyeUJ1ZGdldENvZGVJbnB1dCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKS5jbG9zZXN0KCcuZm9ybS1maWVsZCcpLnNob3coKTtcbiAgICAgICAgfVxuICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShjb3VudHJ5QnVkZ2V0Q29kZVNlbGVjdCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKS5jbG9zZXN0KCcuZm9ybS1maWVsZCcpLnNob3coKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShjb3VudHJ5QnVkZ2V0Q29kZUlucHV0KVxuICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBBaWRUeXBlIEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgYW5kIGNvZGVzIGZpZWxkIGJhc2VkIG9uICdAdm9jYWJ1bGFyeScgZmllbGQgdmFsdWVcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuICAgICAgICB2YXIgYWlkdHlwZV92b2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3RbaWQqPVwiZGVmYXVsdF9haWRfdHlwZV92b2NhYnVsYXJ5XCJdJyk7XG4gICAgICAgIGlmIChhaWR0eXBlX3ZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAganF1ZXJ5XzEuZGVmYXVsdC5lYWNoKGFpZHR5cGVfdm9jYWJ1bGFyeSwgZnVuY3Rpb24gKGluZGV4LCBpdGVtKSB7XG4gICAgICAgICAgICAgICAgdmFyIF9hO1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGl0ZW0pLnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnMSc7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZUFpZFR5cGVTZWxlY3RGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaXRlbSksIGRhdGEudG9TdHJpbmcoKSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIGFpZHR5cGVfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpzZWxlY3QnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gZS5wYXJhbXMuZGF0YS5pZDtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZUFpZFR5cGVTZWxlY3RGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgZGF0YSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIGFpZHR5cGVfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVBaWRUeXBlU2VsZWN0RmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksICcnKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBBaWRUeXBlIEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgYW5kIGNvZGVzIGZpZWxkIGJhc2VkIG9uICdAdm9jYWJ1bGFyeScgZmllbGQgdmFsdWVcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLnRyYW5zYWN0aW9uQWlkVHlwZVZvY2FidWxhcnlIaWRlRmllbGQgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgIHZhciBhaWR0eXBlX3ZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdFtpZCo9XCJhaWRfdHlwZV92b2NhYnVsYXJ5XCJdJyk7XG4gICAgICAgIGlmIChhaWR0eXBlX3ZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAganF1ZXJ5XzEuZGVmYXVsdC5lYWNoKGFpZHR5cGVfdm9jYWJ1bGFyeSwgZnVuY3Rpb24gKGluZGV4LCBpdGVtKSB7XG4gICAgICAgICAgICAgICAgdmFyIF9hO1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGl0ZW0pLnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnMSc7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVRyYW5zYWN0aW9uQWlkVHlwZVNlbGVjdEZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShpdGVtKSwgZGF0YS50b1N0cmluZygpKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgYWlkdHlwZV92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOnNlbGVjdCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSBlLnBhcmFtcy5kYXRhLmlkO1xuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlVHJhbnNhY3Rpb25BaWRUeXBlU2VsZWN0RmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksIGRhdGEpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICBhaWR0eXBlX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6Y2xlYXInLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlVHJhbnNhY3Rpb25BaWRUeXBlU2VsZWN0RmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksICcnKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBIaWRlIEFpZCBUeXBlIFNlbGVjdCBGaWVsZHNcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmhpZGVBaWRUeXBlU2VsZWN0RmllbGQgPSBmdW5jdGlvbiAoaW5kZXgsIHZhbHVlKSB7XG4gICAgICAgIHZhciBkZWZhdWx0X2FpZF90eXBlID0gJ3NlbGVjdFtpZCo9XCJbZGVmYXVsdF9haWRfdHlwZV1cIl0nLCBlYXJtYXJraW5nX2NhdGVnb3J5ID0gJ3NlbGVjdFtpZCo9XCJbZWFybWFya2luZ19jYXRlZ29yeV1cIl0nLCBlYXJtYXJraW5nX21vZGFsaXR5ID0gJ3NlbGVjdFtpZCo9XCJbZWFybWFya2luZ19tb2RhbGl0eV1cIl0nLCBjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXMgPSAnc2VsZWN0W2lkKj1cIltjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXNdXCJdJywgY2FzZTEgPSAnc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX2NhdGVnb3J5XVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfbW9kYWxpdHldXCJdLHNlbGVjdFtpZCo9XCJbY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzXVwiXScsIGNhc2UyID0gJ3NlbGVjdFtpZCo9XCJbZGVmYXVsdF9haWRfdHlwZV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX21vZGFsaXR5XVwiXSxzZWxlY3RbaWQqPVwiW2Nhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllc11cIl0nLCBjYXNlMyA9ICdzZWxlY3RbaWQqPVwiW2RlZmF1bHRfYWlkX3R5cGVdXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19jYXRlZ29yeV1cIl0sc2VsZWN0W2lkKj1cIltjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXNdXCJdJywgY2FzZTQgPSAnc2VsZWN0W2lkKj1cIltkZWZhdWx0X2FpZF90eXBlXVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfY2F0ZWdvcnldXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19tb2RhbGl0eV1cIl0nO1xuICAgICAgICBzd2l0Y2ggKHZhbHVlKSB7XG4gICAgICAgICAgICBjYXNlICcyJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChlYXJtYXJraW5nX2NhdGVnb3J5KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMilcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnMyc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoZWFybWFya2luZ19tb2RhbGl0eSlcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTMpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzQnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllcylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTQpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGRlZmF1bHQ6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoZGVmYXVsdF9haWRfdHlwZSlcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTEpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogSGlkZSBUcmFuc2FjdGlvbiBBaWQgVHlwZSBTZWxlY3QgRmllbGRzXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5oaWRlVHJhbnNhY3Rpb25BaWRUeXBlU2VsZWN0RmllbGQgPSBmdW5jdGlvbiAoaW5kZXgsIHZhbHVlKSB7XG4gICAgICAgIHZhciBhaWRfdHlwZSA9ICdzZWxlY3RbaWQqPVwiW2FpZF90eXBlX2NvZGVdXCJdJywgZWFybWFya2luZ19jYXRlZ29yeSA9ICdzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfY2F0ZWdvcnldXCJdJywgZWFybWFya2luZ19tb2RhbGl0eSA9ICdzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfbW9kYWxpdHldXCJdJywgY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzID0gJ3NlbGVjdFtpZCo9XCJbY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzXVwiXScsIGNhc2UxID0gJ3NlbGVjdFtpZCo9XCJbZWFybWFya2luZ19jYXRlZ29yeV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX21vZGFsaXR5XVwiXSxzZWxlY3RbaWQqPVwiW2Nhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllc11cIl0nLCBjYXNlMiA9ICdzZWxlY3RbaWQqPVwiW2FpZF90eXBlX2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19tb2RhbGl0eV1cIl0sc2VsZWN0W2lkKj1cIltjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXNdXCJdJywgY2FzZTMgPSAnc2VsZWN0W2lkKj1cIlthaWRfdHlwZV9jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfY2F0ZWdvcnldXCJdLHNlbGVjdFtpZCo9XCJbY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzXVwiXScsIGNhc2U0ID0gJ3NlbGVjdFtpZCo9XCJbYWlkX3R5cGVfY29kZV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX2NhdGVnb3J5XVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfbW9kYWxpdHldXCJdJztcbiAgICAgICAgc3dpdGNoICh2YWx1ZSkge1xuICAgICAgICAgICAgY2FzZSAnMic6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoZWFybWFya2luZ19jYXRlZ29yeSlcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTIpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzMnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGVhcm1hcmtpbmdfbW9kYWxpdHkpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UzKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICc0JzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXMpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U0KVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBkZWZhdWx0OlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGFpZF90eXBlKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBQb2xpY3kgTWFya2VyIEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgYW5kIGNvZGVzIGZpZWxkIGJhc2VkIG9uICdAdm9jYWJ1bGFyeScgZmllbGQgdmFsdWVcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLnBvbGljeVZvY2FidWxhcnlIaWRlRmllbGQgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgIHZhciBwb2xpY3ltYWtlcl92b2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3RbaWQqPVwicG9saWN5X21hcmtlcl92b2NhYnVsYXJ5XCJdJyk7XG4gICAgICAgIGlmIChwb2xpY3ltYWtlcl92b2NhYnVsYXJ5Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuZWFjaChwb2xpY3ltYWtlcl92b2NhYnVsYXJ5LCBmdW5jdGlvbiAoaW5kZXgsIHBvbGljeV9tYXJrZXIpIHtcbiAgICAgICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSAoX2EgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkocG9saWN5X21hcmtlcikudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcxJztcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlUG9saWN5TWFrZXJGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkocG9saWN5X21hcmtlciksIGRhdGEudG9TdHJpbmcoKSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIHBvbGljeW1ha2VyX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IGUucGFyYW1zLmRhdGEuaWQ7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVQb2xpY3lNYWtlckZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCBkYXRhKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgcG9saWN5bWFrZXJfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVQb2xpY3lNYWtlckZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCAnMScpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEhpZGVzIFBvbGljeSBNYXJrZXIgRm9ybSBGaWVsZHNcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmhpZGVQb2xpY3lNYWtlckZpZWxkID0gZnVuY3Rpb24gKGluZGV4LCB2YWx1ZSkge1xuICAgICAgICB2YXIgY2FzZTFfc2hvdyA9ICdzZWxlY3RbaWQqPVwiW3BvbGljeV9tYXJrZXJdXCJdJywgY2FzZTJfc2hvdyA9ICdpbnB1dFtpZCo9XCJbcG9saWN5X21hcmtlcl90ZXh0XVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdJywgY2FzZTEgPSAnaW5wdXRbaWQqPVwiW3BvbGljeV9tYXJrZXJfdGV4dF1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXScsIGNhc2UyID0gJ3NlbGVjdFtpZCo9XCJbcG9saWN5X21hcmtlcl1cIl0nO1xuICAgICAgICBzd2l0Y2ggKHZhbHVlKSB7XG4gICAgICAgICAgICBjYXNlICcxJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMV9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnOTknOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBkZWZhdWx0OlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIFNlY3RvciBGb3JtIFBhZ2VcbiAgICAgKlxuICAgICAqIEBMb2dpYyBoaWRlIHZvY2FidWxhcnktdXJpIGFuZCBjb2RlcyBmaWVsZCBiYXNlZCBvbiAnQHZvY2FidWxhcnknIGZpZWxkIHZhbHVlXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5zZWN0b3JWb2NhYnVsYXJ5SGlkZUZpZWxkID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuICAgICAgICB2YXIgc2VjdG9yX3ZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdFtpZCo9XCJzZWN0b3Jfdm9jYWJ1bGFyeVwiXScpO1xuICAgICAgICBpZiAoc2VjdG9yX3ZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAganF1ZXJ5XzEuZGVmYXVsdC5lYWNoKHNlY3Rvcl92b2NhYnVsYXJ5LCBmdW5jdGlvbiAoaW5kZXgsIHNlY3Rvcikge1xuICAgICAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShzZWN0b3IpLnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnMSc7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVNlY3RvckZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShzZWN0b3IpLCBkYXRhLnRvU3RyaW5nKCkpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICBzZWN0b3Jfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpzZWxlY3QnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gZS5wYXJhbXMuZGF0YS5pZDtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVNlY3RvckZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCBkYXRhKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgc2VjdG9yX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6Y2xlYXInLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlU2VjdG9yRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksICcxJyk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogSGlkZSBTZWN0b3IgRm9ybSBmaWVsZHNcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmhpZGVTZWN0b3JGaWVsZCA9IGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcbiAgICAgICAgdmFyIGNhc2UxX3Nob3cgPSAnc2VsZWN0W2lkKj1cIltjb2RlXVwiXScsIGNhc2UyX3Nob3cgPSAnc2VsZWN0W2lkKj1cIltjYXRlZ29yeV9jb2RlXVwiXScsIGNhc2U3X3Nob3cgPSAnc2VsZWN0W2lkKj1cIltzZGdfZ29hbF1cIl0nLCBjYXNlOF9zaG93ID0gJ3NlbGVjdFtpZCo9XCJbc2RnX3RhcmdldF1cIl0nLCBjYXNlOThfOTlfc2hvdyA9ICdpbnB1dFtpZCo9XCJbdGV4dF1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXScsIGRlZmF1bHRfc2hvdyA9ICdpbnB1dFtpZCo9XCJbdGV4dF1cIl0nLCBjYXNlMSA9ICdzZWxlY3RbaWQqPVwiW2NhdGVnb3J5X2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX2dvYWxdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX3RhcmdldF1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSxpbnB1dFtpZCo9XCJbdGV4dF1cIl0nLCBjYXNlMiA9ICdpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdLHNlbGVjdFtpZCo9XCJbc2RnX2dvYWxdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX3RhcmdldF1cIl0sc2VsZWN0W2lkKj1cIltjb2RlXVwiXSxpbnB1dFtpZCo9XCJbdGV4dF1cIl0nLCBjYXNlNyA9ICdpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdLHNlbGVjdFtpZCo9XCJbY2F0ZWdvcnlfY29kZV1cIl0sc2VsZWN0W2lkKj1cIltzZGdfdGFyZ2V0XVwiXSxzZWxlY3RbaWQqPVwiW2NvZGVdXCJdLGlucHV0W2lkKj1cIlt0ZXh0XVwiXScsIGNhc2U4ID0gJ2lucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0sc2VsZWN0W2lkKj1cIltjYXRlZ29yeV9jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ19nb2FsXVwiXSxzZWxlY3RbaWQqPVwiW2NvZGVdXCJdLGlucHV0W2lkKj1cIlt0ZXh0XVwiXScsIGNhc2U5OF85OSA9ICdzZWxlY3RbaWQqPVwiW2NhdGVnb3J5X2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX2dvYWxdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX3RhcmdldF1cIl0sc2VsZWN0W2lkKj1cIltjb2RlXVwiXScsIGRlZmF1bHRfaGlkZSA9ICdzZWxlY3RbaWQqPVwiW2NhdGVnb3J5X2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX2dvYWxdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX3RhcmdldF1cIl0sc2VsZWN0W2lkKj1cIltjb2RlXVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdJztcbiAgICAgICAgc3dpdGNoICh2YWx1ZSkge1xuICAgICAgICAgICAgY2FzZSAnMSc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTFfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTEpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzInOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICc3JzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlN19zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlNylcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnOCc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZThfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTgpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzk4JzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOThfOTlfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTk4Xzk5KVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICc5OSc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTk4Xzk5X3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U5OF85OSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgZGVmYXVsdDpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChkZWZhdWx0X3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGRlZmF1bHRfaGlkZSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiAgUmVjaXBpZW50IFZvY2FidWxhcnkgRm9ybSBQYWdlXG4gICAgICpcbiAgICAgKiBATG9naWMgaGlkZSB2b2NhYnVsYXJ5LXVyaSBhbmQgY29kZXMgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUucmVjaXBpZW50Vm9jYWJ1bGFyeUhpZGVGaWVsZCA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgdmFyIHJlZ2lvbl92b2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3RbaWQqPVwicmVnaW9uX3ZvY2FidWxhcnlcIl0nKTtcbiAgICAgICAgaWYgKHJlZ2lvbl92b2NhYnVsYXJ5Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuZWFjaChyZWdpb25fdm9jYWJ1bGFyeSwgZnVuY3Rpb24gKGluZGV4LCByZWdpb25fdm9jYWIpIHtcbiAgICAgICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSAoX2EgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkocmVnaW9uX3ZvY2FiKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJzEnO1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVSZWNpcGllbnRSZWdpb25GaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkocmVnaW9uX3ZvY2FiKSwgZGF0YS50b1N0cmluZygpKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgcmVnaW9uX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IGUucGFyYW1zLmRhdGEuaWQ7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVSZWNpcGllbnRSZWdpb25GaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgZGF0YSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIHJlZ2lvbl92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVJlY2lwaWVudFJlZ2lvbkZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCAnMScpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEhpZGVzIFJlY2lwaWVudCBSZWdpb24gRm9ybSBGaWVsZHNcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmhpZGVSZWNpcGllbnRSZWdpb25GaWVsZCA9IGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcbiAgICAgICAgdmFyIGNhc2UxX3Nob3cgPSAnc2VsZWN0W2lkKj1cIltyZWdpb25fY29kZV1cIl0nLCBjYXNlMl9zaG93ID0gJ2lucHV0W2lkKj1cIltjdXN0b21fY29kZV1cIl0sIGlucHV0W2lkKj1cIltjb2RlXVwiXScsIGNhc2U5OV9zaG93ID0gJ2lucHV0W2lkKj1cIltjdXN0b21fY29kZV1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSwgaW5wdXRbaWQqPVwiW2NvZGVdXCJdJywgY2FzZTEgPSAnaW5wdXRbaWQqPVwiW2N1c3RvbV9jb2RlXVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdLGlucHV0W2lkKj1cIltjb2RlXVwiXScsIGNhc2UyID0gJ3NlbGVjdFtpZCo9XCJbcmVnaW9uX2NvZGVdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0nLCBjYXNlOTkgPSAnc2VsZWN0W2lkKj1cIltyZWdpb25fY29kZV1cIl0nO1xuICAgICAgICBzd2l0Y2ggKHZhbHVlKSB7XG4gICAgICAgICAgICBjYXNlICcxJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMV9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnMic6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTJfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTIpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzk5JzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOTlfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTk5KVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBkZWZhdWx0OlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIFVwZGF0ZXMgQWN0aXZpdHkgaWRlbnRpZmllclxuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUudXBkYXRlQWN0aXZpdHlJZGVudGlmaWVyID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgYWN0aXZpdHlfaWRlbnRpZmllciA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI2FjdGl2aXR5X2lkZW50aWZpZXInKTtcbiAgICAgICAgaWYgKGFjdGl2aXR5X2lkZW50aWZpZXIubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAgYWN0aXZpdHlfaWRlbnRpZmllci5vbigna2V5dXAnLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjaWF0aV9pZGVudGlmaWVyX3RleHQnKS52YWwoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuaWRlbnRpZmllcicpLmF0dHIoJ2FjdGl2aXR5X2lkZW50aWZpZXInKSArIFwiLVwiLmNvbmNhdCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykudmFsKCkpKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBUYWcgRm9ybSBQYWdlXG4gICAgICpcbiAgICAgKiBATG9naWMgaGlkZSB2b2NhYnVsYXJ5LXVyaSBhbmQgY29kZXMgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUudGFnVm9jYWJ1bGFyeUhpZGVGaWVsZCA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgdmFyIHRhZ192b2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3RbaWQqPVwidGFnX3ZvY2FidWxhcnlcIl0nKTtcbiAgICAgICAgaWYgKHRhZ192b2NhYnVsYXJ5Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuZWFjaCh0YWdfdm9jYWJ1bGFyeSwgZnVuY3Rpb24gKGluZGV4LCB0YWcpIHtcbiAgICAgICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSAoX2EgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFnKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJzEnO1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVUYWdGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFnKSwgZGF0YS50b1N0cmluZygpKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgdGFnX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IGUucGFyYW1zLmRhdGEuaWQ7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVUYWdGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgZGF0YSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIHRhZ192b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVRhZ0ZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCAnMScpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEhpZGUgVGFnIEZvcm0gZmllbGRzXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5oaWRlVGFnRmllbGQgPSBmdW5jdGlvbiAoaW5kZXgsIHZhbHVlKSB7XG4gICAgICAgIHZhciBjYXNlMV9zaG93ID0gJ2lucHV0W2lkKj1cIlt0YWdfdGV4dF1cIl0nLCBjYXNlMl9zaG93ID0gJ3NlbGVjdFtpZCo9XCJbZ29hbHNfdGFnX2NvZGVdXCJdJywgY2FzZTNfc2hvdyA9ICdzZWxlY3RbaWQqPVwiW3RhcmdldHNfdGFnX2NvZGVdXCJdJywgY2FzZTk5X3Nob3cgPSAnaW5wdXRbaWQqPVwiW3RhZ190ZXh0XVwiXSwgaW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXScsIGNhc2UxID0gJ3NlbGVjdFtpZCo9XCJbZ29hbHNfdGFnX2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbdGFyZ2V0c190YWdfY29kZV1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXScsIGNhc2UyID0gJ2lucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0sc2VsZWN0W2lkKj1cIlt0YXJnZXRzX3RhZ19jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW3RhcmdldHNfdGFnX2NvZGVdXCJdLGlucHV0W2lkKj1cIlt0YWdfdGV4dF1cIl0nLCBjYXNlMyA9ICdpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdLHNlbGVjdFtpZCo9XCJbZ29hbHNfdGFnX2NvZGVdXCJdLGlucHV0W2lkKj1cIlt0YWdfdGV4dF1cIl0nLCBjYXNlOTkgPSAnc2VsZWN0W2lkKj1cIltnb2Fsc190YWdfY29kZV1cIl0sc2VsZWN0W2lkKj1cIlt0YXJnZXRzX3RhZ19jb2RlXVwiXSc7XG4gICAgICAgIHN3aXRjaCAodmFsdWUpIHtcbiAgICAgICAgICAgIGNhc2UgJzEnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICcyJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMl9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMilcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnMyc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTNfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTMpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzk5JzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOTlfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTk5KVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBkZWZhdWx0OlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIHJldHVybiBEeW5hbWljRmllbGQ7XG59KCkpO1xuZXhwb3J0cy5EeW5hbWljRmllbGQgPSBEeW5hbWljRmllbGQ7XG4iLCJcInVzZSBzdHJpY3RcIjtcbnZhciBfX2ltcG9ydERlZmF1bHQgPSAodGhpcyAmJiB0aGlzLl9faW1wb3J0RGVmYXVsdCkgfHwgZnVuY3Rpb24gKG1vZCkge1xuICAgIHJldHVybiAobW9kICYmIG1vZC5fX2VzTW9kdWxlKSA/IG1vZCA6IHsgXCJkZWZhdWx0XCI6IG1vZCB9O1xufTtcbk9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBcIl9fZXNNb2R1bGVcIiwgeyB2YWx1ZTogdHJ1ZSB9KTtcbnZhciBqcXVlcnlfMSA9IF9faW1wb3J0RGVmYXVsdChyZXF1aXJlKFwianF1ZXJ5XCIpKTtcbnJlcXVpcmUoXCJzZWxlY3QyXCIpO1xudmFyIER5bmFtaWNGaWVsZF8xID0gcmVxdWlyZShcIi4vRHluYW1pY0ZpZWxkXCIpO1xudmFyIGR5bmFtaWNGaWVsZCA9IG5ldyBEeW5hbWljRmllbGRfMS5EeW5hbWljRmllbGQoKTtcbnZhciBGb3JtQnVpbGRlciA9IC8qKiBAY2xhc3MgKi8gKGZ1bmN0aW9uICgpIHtcbiAgICBmdW5jdGlvbiBGb3JtQnVpbGRlcigpIHtcbiAgICB9XG4gICAgLy8gYWRkcyBuZXcgY29sbGVjdGlvbiBvZiBzdWItZWxlbWVudFxuICAgIEZvcm1CdWlsZGVyLnByb3RvdHlwZS5hZGRGb3JtID0gZnVuY3Rpb24gKGV2KSB7XG4gICAgICAgIGV2LnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIHZhciB0YXJnZXQgPSBldi50YXJnZXQ7XG4gICAgICAgIHZhciBjb250YWluZXIgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdmb3JtX3R5cGUnKVxuICAgICAgICAgICAgPyAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoXCIuY29sbGVjdGlvbi1jb250YWluZXJbZm9ybV90eXBlID0nXCIuY29uY2F0KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2Zvcm1fdHlwZScpLCBcIiddXCIpKVxuICAgICAgICAgICAgOiAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5jb2xsZWN0aW9uLWNvbnRhaW5lcicpO1xuICAgICAgICB2YXIgY291bnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdjaGlsZF9jb3VudCcpXG4gICAgICAgICAgICA/IHBhcnNlSW50KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2NoaWxkX2NvdW50JykpICsgMVxuICAgICAgICAgICAgOiAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wYXJlbnQoKS5maW5kKCcuZm9ybS1jaGlsZC1ib2R5JykubGVuZ3RoO1xuICAgICAgICB2YXIgcGFyZW50X2NvdW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cigncGFyZW50X2NvdW50JylcbiAgICAgICAgICAgID8gcGFyc2VJbnQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cigncGFyZW50X2NvdW50JykpXG4gICAgICAgICAgICA6ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLnBhcmVudHMoJy5tdWx0aS1mb3JtJykuaW5kZXgoKSAtIDE7XG4gICAgICAgIHZhciB3cmFwcGVyX3BhcmVudF9jb3VudCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ3dyYXBwZWRfcGFyZW50X2NvdW50JylcbiAgICAgICAgICAgID8gcGFyc2VJbnQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignd3JhcHBlZF9wYXJlbnRfY291bnQnKSlcbiAgICAgICAgICAgIDogKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucGFyZW50cygnLndyYXBwZWQtY2hpbGQtYm9keScpLmluZGV4KCkgLSAxO1xuICAgICAgICB2YXIgcHJvdG8gPSBjb250YWluZXJcbiAgICAgICAgICAgIC5kYXRhKCdwcm90b3R5cGUnKVxuICAgICAgICAgICAgLnJlcGxhY2UoL19fUEFSRU5UX05BTUVfXy9nLCBwYXJlbnRfY291bnQpO1xuICAgICAgICBpZiAoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignaGFzX2NoaWxkX2NvbGxlY3Rpb24nKSkge1xuICAgICAgICAgICAgcHJvdG8gPSBwcm90by5yZXBsYWNlKC9fX1dSQVBQRVJfTkFNRV9fL2csIGNvdW50KTtcbiAgICAgICAgICAgIHByb3RvID0gcHJvdG8ucmVwbGFjZSgvX19OQU1FX18vZywgMCk7XG4gICAgICAgIH1cbiAgICAgICAgZWxzZSB7XG4gICAgICAgICAgICBwcm90byA9IHByb3RvLnJlcGxhY2UoL19fTkFNRV9fL2csIGNvdW50KTtcbiAgICAgICAgICAgIHByb3RvID0gcHJvdG8ucmVwbGFjZSgvX19XUkFQUEVSX05BTUVfXy9nLCB3cmFwcGVyX3BhcmVudF9jb3VudCk7XG4gICAgICAgIH1cbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucHJldigpLmFwcGVuZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkocHJvdG8pKTtcbiAgICAgICAgaWYgKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2hhc19jaGlsZF9jb2xsZWN0aW9uJykpIHtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXG4gICAgICAgICAgICAgICAgLnByZXYoJy5zdWJlbGVtZW50JylcbiAgICAgICAgICAgICAgICAuY2hpbGRyZW4oJy53cmFwcGVkLWNoaWxkLWJvZHknKVxuICAgICAgICAgICAgICAgIC5sYXN0KClcbiAgICAgICAgICAgICAgICAuZmluZCgnLmFkZF90b19jb2xsZWN0aW9uJylcbiAgICAgICAgICAgICAgICAuYXR0cignd3JhcHBlZF9wYXJlbnRfY291bnQnLCBjb3VudCk7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KVxuICAgICAgICAgICAgICAgIC5wcmV2KCcuc3ViZWxlbWVudCcpXG4gICAgICAgICAgICAgICAgLmNoaWxkcmVuKCcud3JhcHBlZC1jaGlsZC1ib2R5JylcbiAgICAgICAgICAgICAgICAubGFzdCgpXG4gICAgICAgICAgICAgICAgLmZpbmQoJy5hZGRfdG9fY29sbGVjdGlvbicpXG4gICAgICAgICAgICAgICAgLmF0dHIoJ3BhcmVudF9jb3VudCcsIHBhcmVudF9jb3VudCk7XG4gICAgICAgIH1cbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldClcbiAgICAgICAgICAgIC5wcmV2KClcbiAgICAgICAgICAgIC5maW5kKCcud3JhcHBlZC1jaGlsZC1ib2R5JylcbiAgICAgICAgICAgIC5sYXN0KClcbiAgICAgICAgICAgIC5maW5kKCcuYWRkX3RvX2NvbGxlY3Rpb24nKVxuICAgICAgICAgICAgLmF0dHIoJ3dyYXBwZXJfcGFyZW50X2NvdW50Jywgd3JhcHBlcl9wYXJlbnRfY291bnQgIT09IG51bGwgJiYgd3JhcHBlcl9wYXJlbnRfY291bnQgIT09IHZvaWQgMCA/IHdyYXBwZXJfcGFyZW50X2NvdW50IDogMCk7XG4gICAgICAgIGlmICgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdmb3JtX3R5cGUnKSkge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucHJldigpLmxhc3QoKS5maW5kKCcuc2VsZWN0MicpLnNlbGVjdDIoe1xuICAgICAgICAgICAgICAgIHBsYWNlaG9sZGVyOiAnU2VsZWN0IGFuIG9wdGlvbicsXG4gICAgICAgICAgICAgICAgYWxsb3dDbGVhcjogdHJ1ZSxcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpXG4gICAgICAgICAgICAgICAgLmZpbmQoJy5zdWItYXR0cmlidXRlJylcbiAgICAgICAgICAgICAgICAud3JhcEFsbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJzxkaXYgY2xhc3M9XCJmb3JtLWZpZWxkLWdyb3VwIGZsZXggZmxleC13cmFwIHJvdW5kZWQtYnItbGcgYm9yZGVyLXkgYm9yZGVyLXIgYm9yZGVyLXNwcmluZy01MCBzdWItYXR0cmlidXRlLXdyYXBwZXJcIj48L2Rpdj4nKSk7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KVxuICAgICAgICAgICAgICAgIC5wcmV2KCcuc3ViZWxlbWVudCcpXG4gICAgICAgICAgICAgICAgLmNoaWxkcmVuKCcud3JhcHBlZC1jaGlsZC1ib2R5JylcbiAgICAgICAgICAgICAgICAubGFzdCgpXG4gICAgICAgICAgICAgICAgLmZpbmQoJy5zdWItYXR0cmlidXRlJylcbiAgICAgICAgICAgICAgICAud3JhcEFsbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJzxkaXYgY2xhc3M9XCJmb3JtLWZpZWxkLWdyb3VwIGZsZXggZmxleC13cmFwIHJvdW5kZWQtYnItbGcgYm9yZGVyLXkgYm9yZGVyLXIgYm9yZGVyLXNwcmluZy01MCBzdWItYXR0cmlidXRlLXdyYXBwZXIgbXQtNlwiPjwvZGl2PicpKTtcbiAgICAgICAgfVxuICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXG4gICAgICAgICAgICAgICAgLnBhcmVudCgpXG4gICAgICAgICAgICAgICAgLmZpbmQoJy5mb3JtLWNoaWxkLWJvZHknKVxuICAgICAgICAgICAgICAgIC5sYXN0KClcbiAgICAgICAgICAgICAgICAuZmluZCgnLnNlbGVjdDInKVxuICAgICAgICAgICAgICAgIC5zZWxlY3QyKHtcbiAgICAgICAgICAgICAgICBwbGFjZWhvbGRlcjogJ1NlbGVjdCBhbiBvcHRpb24nLFxuICAgICAgICAgICAgICAgIGFsbG93Q2xlYXI6IHRydWUsXG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdjaGlsZF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgZHluYW1pY0ZpZWxkLmFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC5zZWN0b3JWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgfTtcbiAgICAvLyBhZGRzIHBhcmVudCBjb2xsZWN0aW9uXG4gICAgRm9ybUJ1aWxkZXIucHJvdG90eXBlLmFkZFBhcmVudEZvcm0gPSBmdW5jdGlvbiAoZXYpIHtcbiAgICAgICAgZXYucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgdmFyIHRhcmdldCA9IGV2LnRhcmdldDtcbiAgICAgICAgdmFyIGNvbnRhaW5lciA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2Zvcm1fdHlwZScpXG4gICAgICAgICAgICA/ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShcIi5wYXJlbnQtY29sbGVjdGlvbltmb3JtX3R5cGUgPSdcIi5jb25jYXQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignZm9ybV90eXBlJyksIFwiJ11cIikpXG4gICAgICAgICAgICA6ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLnBhcmVudC1jb2xsZWN0aW9uJyk7XG4gICAgICAgIHZhciBjb3VudCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ3BhcmVudF9jb3VudCcpXG4gICAgICAgICAgICA/IHBhcnNlSW50KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ3BhcmVudF9jb3VudCcpKSArIDFcbiAgICAgICAgICAgIDogKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLnByZXYoKS5maW5kKCcubXVsdGktZm9ybScpLmxlbmd0aFxuICAgICAgICAgICAgICAgID8gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucHJldigpLmZpbmQoJy5tdWx0aS1mb3JtJykubGVuZ3RoXG4gICAgICAgICAgICAgICAgOiAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wcmV2KCkuZmluZCgnLndyYXBwZWQtY2hpbGQtYm9keScpLmxlbmd0aCkgKyAxO1xuICAgICAgICB2YXIgcHJvdG8gPSBjb250YWluZXIuZGF0YSgncHJvdG90eXBlJykucmVwbGFjZSgvX19QQVJFTlRfTkFNRV9fL2csIGNvdW50KTtcbiAgICAgICAgcHJvdG8gPSBwcm90by5yZXBsYWNlKC9fX05BTUVfXy9nLCAwKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucHJldigpLmFwcGVuZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkocHJvdG8pKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucHJldigpLmZpbmQoJy5tdWx0aS1mb3JtJykubGFzdCgpLmZpbmQoJy5zZWxlY3QyJykuc2VsZWN0Mih7XG4gICAgICAgICAgICBwbGFjZWhvbGRlcjogJ1NlbGVjdCBhbiBvcHRpb24nLFxuICAgICAgICAgICAgYWxsb3dDbGVhcjogdHJ1ZSxcbiAgICAgICAgfSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXG4gICAgICAgICAgICAucHJldigpXG4gICAgICAgICAgICAuZmluZCgnLm11bHRpLWZvcm0nKVxuICAgICAgICAgICAgLmxhc3QoKVxuICAgICAgICAgICAgLmZpbmQoJy5hZGRfdG9fY29sbGVjdGlvbicpXG4gICAgICAgICAgICAuYXR0cigncGFyZW50X2NvdW50JywgY291bnQpO1xuICAgICAgICB0aGlzLmFkZFdyYXBwZXJPbkFkZCh0YXJnZXQpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdwYXJlbnRfY291bnQnLCBjb3VudCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC5odW1hbml0YXJpYW5TY29wZUhpZGVWb2NhYnVsYXJ5VXJpKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC5jb3VudHJ5QnVkZ2V0SGlkZUNvZGVGaWVsZCgpO1xuICAgICAgICBkeW5hbWljRmllbGQuc2VjdG9yVm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICBkeW5hbWljRmllbGQucmVjaXBpZW50Vm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICBkeW5hbWljRmllbGQucG9saWN5Vm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICBkeW5hbWljRmllbGQudGFnVm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICBkeW5hbWljRmllbGQudHJhbnNhY3Rpb25BaWRUeXBlVm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICBkeW5hbWljRmllbGQuaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkVXJpKCk7XG4gICAgfTtcbiAgICAvLyBkZWxldGVzIGNvbGxlY3Rpb25cbiAgICBGb3JtQnVpbGRlci5wcm90b3R5cGUuZGVsZXRlRm9ybSA9IGZ1bmN0aW9uIChldikge1xuICAgICAgICBldi5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICB2YXIgdGFyZ2V0ID0gZXYudGFyZ2V0O1xuICAgICAgICB2YXIgY29sbGVjdGlvbkxlbmd0aCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLm11bHRpLWZvcm0nKS5sZW5ndGhcbiAgICAgICAgICAgID8gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuY2xvc2VzdCgnLnN1YmVsZW1lbnQnKS5maW5kKCcuZm9ybS1jaGlsZC1ib2R5JykubGVuZ3RoXG4gICAgICAgICAgICA6ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmZvcm0tY2hpbGQtYm9keScpLmxlbmd0aDtcbiAgICAgICAgdmFyIGNvdW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX2NvbGxlY3Rpb24nKS5hdHRyKCdjaGlsZF9jb3VudCcpXG4gICAgICAgICAgICA/IHBhcnNlSW50KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmFkZF90b19jb2xsZWN0aW9uJykuYXR0cignY2hpbGRfY291bnQnKSkgKyAxXG4gICAgICAgICAgICA6IGNvbGxlY3Rpb25MZW5ndGg7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmFkZF90b19jb2xsZWN0aW9uJykuYXR0cignY2hpbGRfY291bnQnLCBjb3VudCk7XG4gICAgICAgIGlmIChjb2xsZWN0aW9uTGVuZ3RoID4gMSkge1xuICAgICAgICAgICAgdmFyIHRnID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuY2xvc2VzdCgnLmZvcm0tY2hpbGQtYm9keScpO1xuICAgICAgICAgICAgdGcubmV4dCgnLmVycm9yJykucmVtb3ZlKCk7XG4gICAgICAgICAgICB0Zy5yZW1vdmUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLy8gZGVsZXRlcyBwYXJlbnQgY29sbGVjdGlvblxuICAgIEZvcm1CdWlsZGVyLnByb3RvdHlwZS5kZWxldGVQYXJlbnRGb3JtID0gZnVuY3Rpb24gKGV2KSB7XG4gICAgICAgIGV2LnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIHZhciB0YXJnZXQgPSBldi50YXJnZXQ7XG4gICAgICAgIHZhciBjb2xsZWN0aW9uTGVuZ3RoID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuc3ViZWxlbWVudCcpLmxlbmd0aDtcbiAgICAgICAgdmFyIGNvdW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX3BhcmVudCcpLmF0dHIoJ2NoaWxkX2NvdW50JylcbiAgICAgICAgICAgID8gcGFyc2VJbnQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX3BhcmVudCcpLmF0dHIoJ2NoaWxkX2NvdW50JykpICsgMVxuICAgICAgICAgICAgOiBjb2xsZWN0aW9uTGVuZ3RoO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5hZGRfdG9fcGFyZW50JykuYXR0cignY2hpbGRfY291bnQnLCBjb3VudCk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmFkZF90b19wYXJlbnQnKS5hdHRyKCdwYXJlbnRfY291bnQnLCBjb3VudCk7XG4gICAgICAgIGlmIChjb2xsZWN0aW9uTGVuZ3RoID4gMikge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucGFyZW50KCkucmVtb3ZlKCk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8vYWRkIHdyYXBwZXIgZGl2IGFyb3VuZCB0aGUgYXR0cmlidXRlc1xuICAgIEZvcm1CdWlsZGVyLnByb3RvdHlwZS5hZGRXcmFwcGVyID0gZnVuY3Rpb24gKCkge1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5tdWx0aS1mb3JtJykuZWFjaChmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcbiAgICAgICAgICAgICAgICAuZmluZCgnLmF0dHJpYnV0ZScpXG4gICAgICAgICAgICAgICAgLndyYXBBbGwoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCc8ZGl2IGNsYXNzPVwiZm9ybS1maWVsZC1ncm91cCBmbGV4IGZsZXgtd3JhcCByb3VuZGVkLWJyLWxnIGJvcmRlci15IGJvcmRlci1yIGJvcmRlci1zcHJpbmctNTAgYXR0cmlidXRlLXdyYXBwZXIgbWItNFwiPjwvZGl2PicpKTtcbiAgICAgICAgfSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLnN1YmVsZW1lbnQnKVxuICAgICAgICAgICAgLmZpbmQoJy53cmFwcGVkLWNoaWxkLWJvZHknKVxuICAgICAgICAgICAgLmVhY2goZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpXG4gICAgICAgICAgICAgICAgLmZpbmQoJy5zdWItYXR0cmlidXRlJylcbiAgICAgICAgICAgICAgICAud3JhcEFsbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJzxkaXYgY2xhc3M9XCJmb3JtLWZpZWxkLWdyb3VwIGZsZXggZmxleC13cmFwIHJvdW5kZWQtYnItbGcgYm9yZGVyLXkgYm9yZGVyLXIgYm9yZGVyLXNwcmluZy01MCBzdWItYXR0cmlidXRlLXdyYXBwZXIgbWItNFwiPjwvZGl2PicpKTtcbiAgICAgICAgfSk7XG4gICAgICAgIHZhciBmb3JtRmllbGQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2Zvcm0+LmZvcm0tZmllbGQnKTtcbiAgICAgICAgaWYgKGZvcm1GaWVsZC5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBmb3JtRmllbGQud3JhcEFsbCgnPGRpdiBjbGFzcz1cImZvcm0tZmllbGQtZ3JvdXAtb3V0ZXIgZ3JpZCB4bDpncmlkLWNvbHMtMiBtYi02IC1teC0zIGdhcC15LTZcIj48L2Rpdj4nKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgRm9ybUJ1aWxkZXIucHJvdG90eXBlLmFkZFdyYXBwZXJPbkFkZCA9IGZ1bmN0aW9uICh0YXJnZXQpIHtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldClcbiAgICAgICAgICAgIC5wcmV2KClcbiAgICAgICAgICAgIC5maW5kKCcubXVsdGktZm9ybScpXG4gICAgICAgICAgICAubGFzdCgpXG4gICAgICAgICAgICAuZmluZCgnLmF0dHJpYnV0ZScpXG4gICAgICAgICAgICAud3JhcEFsbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJzxkaXYgY2xhc3M9XCJmb3JtLWZpZWxkLWdyb3VwIGdyaWQgeGw6Z3JpZC1jb2xzLTIgcm91bmRlZC1ici1sZyBib3JkZXIteSBib3JkZXItciBib3JkZXItc3ByaW5nLTUwIGF0dHJpYnV0ZS13cmFwcGVyIG1iLTRcIj48L2Rpdj4nKSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXG4gICAgICAgICAgICAucHJldigpXG4gICAgICAgICAgICAuZmluZCgnLm11bHRpLWZvcm0nKVxuICAgICAgICAgICAgLmxhc3QoKVxuICAgICAgICAgICAgLmZpbmQoJy5zdWJlbGVtZW50JylcbiAgICAgICAgICAgIC5maW5kKCcud3JhcHBlZC1jaGlsZC1ib2R5JylcbiAgICAgICAgICAgIC5lYWNoKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKVxuICAgICAgICAgICAgICAgIC5maW5kKCcuc3ViLWF0dHJpYnV0ZScpXG4gICAgICAgICAgICAgICAgLndyYXBBbGwoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCc8ZGl2IGNsYXNzPVwiZm9ybS1maWVsZC1ncm91cCBmbGV4IGZsZXgtd3JhcCByb3VuZGVkLWJyLWxnIGJvcmRlci15IGJvcmRlci1yIGJvcmRlci1zcHJpbmctNTAgc3ViLWF0dHJpYnV0ZS13cmFwcGVyIG1iLTRcIj48L2Rpdj4nKSk7XG4gICAgICAgIH0pO1xuICAgIH07XG4gICAgRm9ybUJ1aWxkZXIucHJvdG90eXBlLnRleHRBcmVhSGVpZ2h0ID0gZnVuY3Rpb24gKGV2KSB7XG4gICAgICAgIHZhciB0YXJnZXQgPSBldi50YXJnZXQ7XG4gICAgICAgIHZhciBoZWlnaHQgPSB0YXJnZXQuc2Nyb2xsSGVpZ2h0O1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5jc3MoJ2hlaWdodCcsIGhlaWdodCk7XG4gICAgfTtcbiAgICBGb3JtQnVpbGRlci5wcm90b3R5cGUuYWRkVG9Db2xsZWN0aW9uID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCAnLmFkZF90b19jb2xsZWN0aW9uJywgZnVuY3Rpb24gKGV2ZW50KSB7XG4gICAgICAgICAgICBpZiAoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGV2ZW50LnRhcmdldCkuaGFzQ2xhc3MoJ2FkZC1pY29uJykpIHtcbiAgICAgICAgICAgICAgICBldmVudC5zdG9wUHJvcGFnYXRpb24oKTtcbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoZXZlbnQudGFyZ2V0KVxuICAgICAgICAgICAgICAgICAgICAucGFyZW50KCdidXR0b24nKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2xpY2snKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgICAgIF90aGlzLmFkZEZvcm0oZXZlbnQpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX3BhcmVudCcpLm9uKCdjbGljaycsIGZ1bmN0aW9uIChldmVudCkge1xuICAgICAgICAgICAgaWYgKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShldmVudC50YXJnZXQpLmhhc0NsYXNzKCdhZGQtaWNvbicpKSB7XG4gICAgICAgICAgICAgICAgZXZlbnQuc3RvcFByb3BhZ2F0aW9uKCk7XG4gICAgICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGV2ZW50LnRhcmdldClcbiAgICAgICAgICAgICAgICAgICAgLnBhcmVudCgnYnV0dG9uJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NsaWNrJyk7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgICAgICBfdGhpcy5hZGRQYXJlbnRGb3JtKGV2ZW50KTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSk7XG4gICAgfTtcbiAgICBGb3JtQnVpbGRlci5wcm90b3R5cGUuZGVsZXRlQ29sbGVjdGlvbiA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgdmFyIGRlbGV0ZUNvbmZpcm1hdGlvbiA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmRlbGV0ZS1jb25maXJtYXRpb24nKSwgY2FuY2VsUG9wdXAgPSAnLmNhbmNlbC1wb3B1cCcsIGRlbGV0ZUNvbmZpcm0gPSAnLmRlbGV0ZS1jb25maXJtJztcbiAgICAgICAgdmFyIGRlbGV0ZUluZGV4ID0ge30sIGNoaWxkT3JQYXJlbnQgPSAnJztcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgJy5kZWxldGUnLCBmdW5jdGlvbiAoZXZlbnQpIHtcbiAgICAgICAgICAgIGRlbGV0ZUNvbmZpcm1hdGlvbi5mYWRlSW4oKTtcbiAgICAgICAgICAgIGRlbGV0ZUluZGV4ID0gZXZlbnQ7XG4gICAgICAgICAgICBjaGlsZE9yUGFyZW50ID0gJ2NoaWxkJztcbiAgICAgICAgfSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsIGNhbmNlbFBvcHVwLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICBkZWxldGVDb25maXJtYXRpb24uZmFkZU91dCgpO1xuICAgICAgICAgICAgZGVsZXRlSW5kZXggPSB7fTtcbiAgICAgICAgICAgIGNoaWxkT3JQYXJlbnQgPSAnJztcbiAgICAgICAgfSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsIGRlbGV0ZUNvbmZpcm0sIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgIGlmIChjaGlsZE9yUGFyZW50ID09PSAnY2hpbGQnKSB7XG4gICAgICAgICAgICAgICAgX3RoaXMuZGVsZXRlRm9ybShkZWxldGVJbmRleCk7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBlbHNlIGlmIChjaGlsZE9yUGFyZW50ID09PSAncGFyZW50Jykge1xuICAgICAgICAgICAgICAgIF90aGlzLmRlbGV0ZVBhcmVudEZvcm0oZGVsZXRlSW5kZXgpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZGVsZXRlQ29uZmlybWF0aW9uLmZhZGVPdXQoKTtcbiAgICAgICAgICAgIGRlbGV0ZUluZGV4ID0ge307XG4gICAgICAgICAgICBjaGlsZE9yUGFyZW50ID0gJyc7XG4gICAgICAgIH0pO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCAnLmRlbGV0ZS1wYXJlbnQnLCBmdW5jdGlvbiAoZXZlbnQpIHtcbiAgICAgICAgICAgIGRlbGV0ZUNvbmZpcm1hdGlvbi5mYWRlSW4oKTtcbiAgICAgICAgICAgIGRlbGV0ZUluZGV4ID0gZXZlbnQ7XG4gICAgICAgICAgICBjaGlsZE9yUGFyZW50ID0gJ3BhcmVudCc7XG4gICAgICAgIH0pO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5zZWxlY3QyJykuc2VsZWN0Mih7XG4gICAgICAgICAgICBwbGFjZWhvbGRlcjogJ1NlbGVjdCBhbiBvcHRpb24nLFxuICAgICAgICAgICAgYWxsb3dDbGVhcjogdHJ1ZSxcbiAgICAgICAgfSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjaGFuZ2UnLCAnaW5wdXRbaWQqPVwiW2RvY3VtZW50XVwiXScsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgIHZhciBfYSwgX2IsIF9jO1xuICAgICAgICAgICAgdmFyIGVuZHBvaW50ID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuZW5kcG9pbnQnKS5hdHRyKCdlbmRwb2ludCcpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnJztcbiAgICAgICAgICAgIHZhciBmaWxlX25hbWUgPSAoKF9iID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpLnZhbCgpKSAhPT0gbnVsbCAmJiBfYiAhPT0gdm9pZCAwID8gX2IgOiAnJykudG9TdHJpbmcoKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKVxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgLmZpbmQoJ2lucHV0W2lkKj1cIlt1cmxdXCJdJylcbiAgICAgICAgICAgICAgICAudmFsKFwiXCIuY29uY2F0KGVuZHBvaW50LCBcIi9cIikuY29uY2F0KChfYyA9IGZpbGVfbmFtZSA9PT0gbnVsbCB8fCBmaWxlX25hbWUgPT09IHZvaWQgMCA/IHZvaWQgMCA6IGZpbGVfbmFtZS5zcGxpdCgnXFxcXCcpLnBvcCgpKSA9PT0gbnVsbCB8fCBfYyA9PT0gdm9pZCAwID8gdm9pZCAwIDogX2MucmVwbGFjZSgnICcsICdfJykpKTtcbiAgICAgICAgfSk7XG4gICAgfTtcbiAgICByZXR1cm4gRm9ybUJ1aWxkZXI7XG59KCkpO1xuKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGZ1bmN0aW9uICgpIHtcbiAgICB2YXIgZm9ybUJ1aWxkZXIgPSBuZXcgRm9ybUJ1aWxkZXIoKTtcbiAgICBmb3JtQnVpbGRlci5hZGRXcmFwcGVyKCk7XG4gICAgZHluYW1pY0ZpZWxkLmhpZGVTaG93Rm9ybUZpZWxkcygpO1xuICAgIGR5bmFtaWNGaWVsZC51cGRhdGVBY3Rpdml0eUlkZW50aWZpZXIoKTtcbiAgICBmb3JtQnVpbGRlci5hZGRUb0NvbGxlY3Rpb24oKTtcbiAgICBmb3JtQnVpbGRlci5kZWxldGVDb2xsZWN0aW9uKCk7XG4gICAgLyoqXG4gICAgICogVGV4dCBhcmVhIGhlaWdodCBvbiB0eXBpbmdcbiAgICAgKi9cbiAgICB2YXIgdGV4dEFyZWFUYXJnZXQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3RleHRhcmVhLmZvcm1fX2lucHV0Jyk7XG4gICAgaWYgKHRleHRBcmVhVGFyZ2V0Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2lucHV0JywgJ3RleHRhcmVhLmZvcm1fX2lucHV0JywgZnVuY3Rpb24gKGV2ZW50KSB7XG4gICAgICAgICAgICBmb3JtQnVpbGRlci50ZXh0QXJlYUhlaWdodChldmVudCk7XG4gICAgICAgIH0pO1xuICAgIH1cbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignc2VsZWN0MjpvcGVuJywgJy5zZWxlY3QyJywgZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgc2VsZWN0X3NlYXJjaCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5zZWxlY3QyLXNlYXJjaF9fZmllbGQnKTtcbiAgICAgICAgaWYgKHNlbGVjdF9zZWFyY2gpIHtcbiAgICAgICAgICAgIHNlbGVjdF9zZWFyY2guZm9jdXMoKTtcbiAgICAgICAgfVxuICAgIH0pO1xuICAgIC8qKlxuICAgICAqIGNoZWNrcyByZWdpc3RyYXRpb24gYWdlbmN5LCBjb3VudHJ5IGFuZCByZWdpc3RyYXRpb24gbnVtYmVyIHRvIGRlZHVjZSBpZGVudGlmaWVyXG4gICAgICovXG4gICAgdXBkYXRlUmVnaXN0cmF0aW9uQWdlbmN5KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI29yZ2FuaXphdGlvbl9jb3VudHJ5JykpO1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI29yZ2FuaXNhdGlvbl9pZGVudGlmaWVyJykuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKTtcbiAgICBmdW5jdGlvbiB1cGRhdGVSZWdpc3RyYXRpb25BZ2VuY3koY291bnRyeSkge1xuICAgICAgICBpZiAoY291bnRyeS52YWwoKSkge1xuICAgICAgICAgICAganF1ZXJ5XzEuZGVmYXVsdC5hamF4KHsgdXJsOiAnL29yZ2FuaXNhdGlvbi9hZ2VuY3kvJyArIGNvdW50cnkudmFsKCkgfSkudGhlbihmdW5jdGlvbiAocmVzcG9uc2UpIHtcbiAgICAgICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICAgICAgdmFyIGN1cnJlbnRfdmFsID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjb3JnYW5pemF0aW9uX3JlZ2lzdHJhdGlvbl9hZ2VuY3knKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJyc7XG4gICAgICAgICAgICAgICAgdmFyIHZhbCA9IGZhbHNlO1xuICAgICAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI29yZ2FuaXphdGlvbl9yZWdpc3RyYXRpb25fYWdlbmN5JykuZW1wdHkoKTtcbiAgICAgICAgICAgICAgICBmb3IgKHZhciBkYXRhIGluIHJlc3BvbnNlLmRhdGEpIHtcbiAgICAgICAgICAgICAgICAgICAgaWYgKGRhdGEgPT09IGN1cnJlbnRfdmFsKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICB2YWwgPSB0cnVlO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI29yZ2FuaXphdGlvbl9yZWdpc3RyYXRpb25fYWdlbmN5JylcbiAgICAgICAgICAgICAgICAgICAgICAgIC5hcHBlbmQobmV3IE9wdGlvbihyZXNwb25zZS5kYXRhW2RhdGFdLCBkYXRhLCB0cnVlLCB0cnVlKSlcbiAgICAgICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJyk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI29yZ2FuaXphdGlvbl9yZWdpc3RyYXRpb25fYWdlbmN5JylcbiAgICAgICAgICAgICAgICAgICAgLnZhbCh2YWwgPyBjdXJyZW50X3ZhbCA6ICcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJyk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH1cbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignc2VsZWN0MjpzZWxlY3QnLCAnI29yZ2FuaXphdGlvbl9jb3VudHJ5JywgZnVuY3Rpb24gKCkge1xuICAgICAgICB1cGRhdGVSZWdpc3RyYXRpb25BZ2VuY3koKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpKTtcbiAgICB9KTtcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignc2VsZWN0MjpzZWxlY3QnLCAnI29yZ2FuaXphdGlvbl9yZWdpc3RyYXRpb25fYWdlbmN5JywgZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgaWRlbnRpZmllciA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS52YWwoKSArICctJyArICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI3JlZ2lzdHJhdGlvbl9udW1iZXInKS52YWwoKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjb3JnYW5pc2F0aW9uX2lkZW50aWZpZXInKS52YWwoaWRlbnRpZmllcik7XG4gICAgfSk7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ3NlbGVjdDI6Y2xlYXInLCAnI29yZ2FuaXphdGlvbl9yZWdpc3RyYXRpb25fYWdlbmN5JywgZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgaWRlbnRpZmllciA9ICctJyArICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI3JlZ2lzdHJhdGlvbl9udW1iZXInKS52YWwoKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjb3JnYW5pc2F0aW9uX2lkZW50aWZpZXInKS52YWwoaWRlbnRpZmllcik7XG4gICAgfSk7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2tleXVwJywgJyNyZWdpc3RyYXRpb25fbnVtYmVyJywgZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgaWRlbnRpZmllciA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI29yZ2FuaXphdGlvbl9yZWdpc3RyYXRpb25fYWdlbmN5JykudmFsKCkgKyAnLScgKyAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykudmFsKCk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI29yZ2FuaXNhdGlvbl9pZGVudGlmaWVyJykudmFsKGlkZW50aWZpZXIpO1xuICAgIH0pO1xuICAgIC8vIGFkZCBjbGFzcyB0byB0aXRsZSBvZiBjb2xsZWN0aW9uIHdoZW4gdmFsaWRhdGlvbiBlcnJvciBvY2N1cnMgb24gY29sbGVjdGlvbiBsZXZlbFxuICAgIHZhciBzdWJlbGVtZW50ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLnN1YmVsZW1lbnQnKTtcbiAgICBmb3IgKHZhciBpID0gMDsgaSA8IHN1YmVsZW1lbnQubGVuZ3RoOyBpKyspIHtcbiAgICAgICAgdmFyIHRpdGxlID0gc3ViZWxlbWVudFtpXS5xdWVyeVNlbGVjdG9yKCcuY29udHJvbC1sYWJlbCcpO1xuICAgICAgICB2YXIgZXJyb3JDb250YWluZXIgPSBzdWJlbGVtZW50W2ldLnF1ZXJ5U2VsZWN0b3IoJy5jb2xsZWN0aW9uX2Vycm9yJyk7XG4gICAgICAgIHZhciBjaGlsZENvdW50ID0gZXJyb3JDb250YWluZXIgPT09IG51bGwgfHwgZXJyb3JDb250YWluZXIgPT09IHZvaWQgMCA/IHZvaWQgMCA6IGVycm9yQ29udGFpbmVyLmNoaWxkRWxlbWVudENvdW50O1xuICAgICAgICBpZiAoY2hpbGRDb3VudCAmJiBjaGlsZENvdW50ID4gMCkge1xuICAgICAgICAgICAgdGl0bGUgPT09IG51bGwgfHwgdGl0bGUgPT09IHZvaWQgMCA/IHZvaWQgMCA6IHRpdGxlLmNsYXNzTGlzdC5hZGQoJ2Vycm9yLXRpdGxlJyk7XG4gICAgICAgIH1cbiAgICB9XG4gICAgLy8gQWRkaW5nIGN1cnNvciBub3QgYWxsb3dlZCB0byA8c2VsZWN0PiB3aGVyZSBlbGVtZW50SnNvblNjaGVtYSByZWFkX29ubHkgOiB0cnVlXG4gICAgdmFyIHJlYWRPbmx5U2VsZWN0cyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoXCJzZWxlY3QuY3Vyc29yLW5vdC1hbGxvd2VkXCIpO1xuICAgIGZvciAodmFyIGkgPSAwOyBpIDwgcmVhZE9ubHlTZWxlY3RzLmxlbmd0aDsgaSsrKSB7XG4gICAgICAgIHZhciBzZWxlY3QgPSByZWFkT25seVNlbGVjdHNbaV07XG4gICAgICAgIHZhciBzZWxlY3RFbGVtZW50UGFyZW50V3JhcHBlciA9IHNlbGVjdC5uZXh0U2libGluZztcbiAgICAgICAgdmFyIHNlbGVjdEVsZW1lbnRQYXJlbnQgPSBzZWxlY3RFbGVtZW50UGFyZW50V3JhcHBlciA9PT0gbnVsbCB8fCBzZWxlY3RFbGVtZW50UGFyZW50V3JhcHBlciA9PT0gdm9pZCAwID8gdm9pZCAwIDogc2VsZWN0RWxlbWVudFBhcmVudFdyYXBwZXIuZmlyc3RDaGlsZDtcbiAgICAgICAgdmFyIHNlbGVjdEVsZW1lbnQgPSBzZWxlY3RFbGVtZW50UGFyZW50ID09PSBudWxsIHx8IHNlbGVjdEVsZW1lbnRQYXJlbnQgPT09IHZvaWQgMCA/IHZvaWQgMCA6IHNlbGVjdEVsZW1lbnRQYXJlbnQuZmlyc3RDaGlsZDtcbiAgICAgICAgaWYgKHNlbGVjdEVsZW1lbnQpIHtcbiAgICAgICAgICAgIHNlbGVjdEVsZW1lbnQuc3R5bGUuY3Vyc29yID0gXCJub3QtYWxsb3dlZFwiO1xuICAgICAgICB9XG4gICAgfVxufSk7XG4iXSwibmFtZXMiOlsiX19pbXBvcnREZWZhdWx0IiwibW9kIiwiX19lc01vZHVsZSIsIk9iamVjdCIsImRlZmluZVByb3BlcnR5IiwiZXhwb3J0cyIsInZhbHVlIiwiRHluYW1pY0ZpZWxkIiwianF1ZXJ5XzEiLCJyZXF1aXJlIiwicHJvdG90eXBlIiwiaGlkZVNob3dGb3JtRmllbGRzIiwiaHVtYW5pdGFyaWFuU2NvcGVIaWRlVm9jYWJ1bGFyeVVyaSIsImNvdW50cnlCdWRnZXRIaWRlQ29kZUZpZWxkIiwiYWlkVHlwZVZvY2FidWxhcnlIaWRlRmllbGQiLCJzZWN0b3JWb2NhYnVsYXJ5SGlkZUZpZWxkIiwicG9saWN5Vm9jYWJ1bGFyeUhpZGVGaWVsZCIsInJlY2lwaWVudFZvY2FidWxhcnlIaWRlRmllbGQiLCJ0YWdWb2NhYnVsYXJ5SGlkZUZpZWxkIiwidHJhbnNhY3Rpb25BaWRUeXBlVm9jYWJ1bGFyeUhpZGVGaWVsZCIsImluZGljYXRvclJlZmVyZW5jZUhpZGVGaWVsZFVyaSIsIl90aGlzIiwiaHVtYW5pdGFyaWFuU2NvcGVWb2NhYnVsYXJ5IiwibGVuZ3RoIiwiZWFjaCIsImluZGV4Iiwic2NvcGUiLCJfYSIsInZhbCIsImhpZGVIdW1hbml0YXJpYW5TY29wZUZpZWxkIiwidG9TdHJpbmciLCJvbiIsImUiLCJwYXJhbXMiLCJkYXRhIiwiaWQiLCJ0YXJnZXQiLCJjbG9zZXN0IiwiZmluZCIsInNob3ciLCJyZW1vdmVBdHRyIiwidHJpZ2dlciIsImhpZGUiLCJhdHRyIiwicmVmZXJlbmNlVm9jYWJ1bGFyeSIsImluZGljYXRvclJlZmVyZW5jZUhpZGVGaWVsZCIsInJlZmVyZW5jZVVyaSIsImNvdW50cnlCdWRnZXRWb2NhYnVsYXJ5IiwiaGlkZUNvdW50cnlCdWRnZXRGaWVsZCIsImNvdW50cnlCdWRnZXRDb2RlSW5wdXQiLCJjb3VudHJ5QnVkZ2V0Q29kZVNlbGVjdCIsImFpZHR5cGVfdm9jYWJ1bGFyeSIsIml0ZW0iLCJoaWRlQWlkVHlwZVNlbGVjdEZpZWxkIiwiaGlkZVRyYW5zYWN0aW9uQWlkVHlwZVNlbGVjdEZpZWxkIiwiZGVmYXVsdF9haWRfdHlwZSIsImVhcm1hcmtpbmdfY2F0ZWdvcnkiLCJlYXJtYXJraW5nX21vZGFsaXR5IiwiY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzIiwiY2FzZTEiLCJjYXNlMiIsImNhc2UzIiwiY2FzZTQiLCJhaWRfdHlwZSIsInBvbGljeW1ha2VyX3ZvY2FidWxhcnkiLCJwb2xpY3lfbWFya2VyIiwiaGlkZVBvbGljeU1ha2VyRmllbGQiLCJjYXNlMV9zaG93IiwiY2FzZTJfc2hvdyIsInNlY3Rvcl92b2NhYnVsYXJ5Iiwic2VjdG9yIiwiaGlkZVNlY3RvckZpZWxkIiwiY2FzZTdfc2hvdyIsImNhc2U4X3Nob3ciLCJjYXNlOThfOTlfc2hvdyIsImRlZmF1bHRfc2hvdyIsImNhc2U3IiwiY2FzZTgiLCJjYXNlOThfOTkiLCJkZWZhdWx0X2hpZGUiLCJyZWdpb25fdm9jYWJ1bGFyeSIsInJlZ2lvbl92b2NhYiIsImhpZGVSZWNpcGllbnRSZWdpb25GaWVsZCIsImNhc2U5OV9zaG93IiwiY2FzZTk5IiwidXBkYXRlQWN0aXZpdHlJZGVudGlmaWVyIiwiYWN0aXZpdHlfaWRlbnRpZmllciIsImNvbmNhdCIsInRhZ192b2NhYnVsYXJ5IiwidGFnIiwiaGlkZVRhZ0ZpZWxkIiwiY2FzZTNfc2hvdyIsIkR5bmFtaWNGaWVsZF8xIiwiZHluYW1pY0ZpZWxkIiwiRm9ybUJ1aWxkZXIiLCJhZGRGb3JtIiwiZXYiLCJwcmV2ZW50RGVmYXVsdCIsImNvbnRhaW5lciIsImNvdW50IiwicGFyc2VJbnQiLCJwYXJlbnQiLCJwYXJlbnRfY291bnQiLCJwYXJlbnRzIiwid3JhcHBlcl9wYXJlbnRfY291bnQiLCJwcm90byIsInJlcGxhY2UiLCJwcmV2IiwiYXBwZW5kIiwiY2hpbGRyZW4iLCJsYXN0Iiwic2VsZWN0MiIsInBsYWNlaG9sZGVyIiwiYWxsb3dDbGVhciIsIndyYXBBbGwiLCJhZGRQYXJlbnRGb3JtIiwiYWRkV3JhcHBlck9uQWRkIiwiZGVsZXRlRm9ybSIsImNvbGxlY3Rpb25MZW5ndGgiLCJ0ZyIsIm5leHQiLCJyZW1vdmUiLCJkZWxldGVQYXJlbnRGb3JtIiwiYWRkV3JhcHBlciIsImZvcm1GaWVsZCIsInRleHRBcmVhSGVpZ2h0IiwiaGVpZ2h0Iiwic2Nyb2xsSGVpZ2h0IiwiY3NzIiwiYWRkVG9Db2xsZWN0aW9uIiwiZXZlbnQiLCJoYXNDbGFzcyIsInN0b3BQcm9wYWdhdGlvbiIsImRlbGV0ZUNvbGxlY3Rpb24iLCJkZWxldGVDb25maXJtYXRpb24iLCJjYW5jZWxQb3B1cCIsImRlbGV0ZUNvbmZpcm0iLCJkZWxldGVJbmRleCIsImNoaWxkT3JQYXJlbnQiLCJmYWRlSW4iLCJmYWRlT3V0IiwiX2IiLCJfYyIsImVuZHBvaW50IiwiZmlsZV9uYW1lIiwic3BsaXQiLCJwb3AiLCJmb3JtQnVpbGRlciIsInRleHRBcmVhVGFyZ2V0Iiwic2VsZWN0X3NlYXJjaCIsImRvY3VtZW50IiwicXVlcnlTZWxlY3RvciIsImZvY3VzIiwidXBkYXRlUmVnaXN0cmF0aW9uQWdlbmN5IiwiY291bnRyeSIsImFqYXgiLCJ1cmwiLCJ0aGVuIiwicmVzcG9uc2UiLCJjdXJyZW50X3ZhbCIsImVtcHR5IiwiT3B0aW9uIiwiaWRlbnRpZmllciIsInN1YmVsZW1lbnQiLCJxdWVyeVNlbGVjdG9yQWxsIiwiaSIsInRpdGxlIiwiZXJyb3JDb250YWluZXIiLCJjaGlsZENvdW50IiwiY2hpbGRFbGVtZW50Q291bnQiLCJjbGFzc0xpc3QiLCJhZGQiLCJyZWFkT25seVNlbGVjdHMiLCJzZWxlY3QiLCJzZWxlY3RFbGVtZW50UGFyZW50V3JhcHBlciIsIm5leHRTaWJsaW5nIiwic2VsZWN0RWxlbWVudFBhcmVudCIsImZpcnN0Q2hpbGQiLCJzZWxlY3RFbGVtZW50Iiwic3R5bGUiLCJjdXJzb3IiXSwic291cmNlUm9vdCI6IiJ9
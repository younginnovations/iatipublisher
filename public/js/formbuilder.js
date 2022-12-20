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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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QUF0QixFQUFrRG9CLEdBQWxELENBQXNEd0ksVUFBdEQ7RUFDSCxDQUhEO0VBSUEsQ0FBQyxHQUFHNUosUUFBUSxXQUFaLEVBQXNCLE1BQXRCLEVBQThCdUIsRUFBOUIsQ0FBaUMsT0FBakMsRUFBMEMsc0JBQTFDLEVBQWtFLFlBQVk7SUFDMUUsSUFBSXFJLFVBQVUsR0FBRyxDQUFDLEdBQUc1SixRQUFRLFdBQVosRUFBc0IsbUNBQXRCLEVBQTJEb0IsR0FBM0QsS0FBbUUsR0FBbkUsR0FBeUUsQ0FBQyxHQUFHcEIsUUFBUSxXQUFaLEVBQXNCLElBQXRCLEVBQTRCb0IsR0FBNUIsRUFBMUY7SUFDQSxDQUFDLEdBQUdwQixRQUFRLFdBQVosRUFBc0IsMEJBQXRCLEVBQWtEb0IsR0FBbEQsQ0FBc0R3SSxVQUF0RDtFQUNILENBSEQ7QUFJSCxDQWhFRCIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3Jlc291cmNlcy9hc3NldHMvanMvc2NyaXB0cy9EeW5hbWljRmllbGQudHMiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9qcy9zY3JpcHRzL2Zvcm1idWlsZGVyLnRzIl0sInNvdXJjZXNDb250ZW50IjpbIlwidXNlIHN0cmljdFwiO1xudmFyIF9faW1wb3J0RGVmYXVsdCA9ICh0aGlzICYmIHRoaXMuX19pbXBvcnREZWZhdWx0KSB8fCBmdW5jdGlvbiAobW9kKSB7XG4gICAgcmV0dXJuIChtb2QgJiYgbW9kLl9fZXNNb2R1bGUpID8gbW9kIDogeyBcImRlZmF1bHRcIjogbW9kIH07XG59O1xuT2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFwiX19lc01vZHVsZVwiLCB7IHZhbHVlOiB0cnVlIH0pO1xuZXhwb3J0cy5EeW5hbWljRmllbGQgPSB2b2lkIDA7XG52YXIganF1ZXJ5XzEgPSBfX2ltcG9ydERlZmF1bHQocmVxdWlyZShcImpxdWVyeVwiKSk7XG5yZXF1aXJlKFwic2VsZWN0MlwiKTtcbnZhciBEeW5hbWljRmllbGQgPSAvKiogQGNsYXNzICovIChmdW5jdGlvbiAoKSB7XG4gICAgZnVuY3Rpb24gRHluYW1pY0ZpZWxkKCkge1xuICAgIH1cbiAgICAvKipcbiAgICAgKiBIaWRlIGFuZCBTaG93IGRpZmZlcmVudCBmb3JtIGZpZWxkcyBiYXNlZCBvbiB2b2NhYnVsYXJ5IGFuZCBvdGhlciB0eXBlc1xuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaGlkZVNob3dGb3JtRmllbGRzID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB0aGlzLmh1bWFuaXRhcmlhblNjb3BlSGlkZVZvY2FidWxhcnlVcmkoKTtcbiAgICAgICAgdGhpcy5jb3VudHJ5QnVkZ2V0SGlkZUNvZGVGaWVsZCgpO1xuICAgICAgICB0aGlzLmFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIHRoaXMuc2VjdG9yVm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICB0aGlzLnBvbGljeVZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgdGhpcy5yZWNpcGllbnRWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIHRoaXMuc2VjdG9yVm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICB0aGlzLnRhZ1ZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgdGhpcy50cmFuc2FjdGlvbkFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIHRoaXMuaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkVXJpKCk7XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBIdW1hbml0YXJpYW4gU2NvcGUgRm9ybSBQYWdlXG4gICAgICpcbiAgICAgKiBATG9naWMgaGlkZSB2b2NhYnVsYXJ5LXVyaSBmaWVsZCBiYXNlZCBvbiAnQHZvY2FidWxhcnknIGZpZWxkIHZhbHVlXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5odW1hbml0YXJpYW5TY29wZUhpZGVWb2NhYnVsYXJ5VXJpID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuICAgICAgICB2YXIgaHVtYW5pdGFyaWFuU2NvcGVWb2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3RbaWRePVwiaHVtYW5pdGFyaWFuX3Njb3BlXCJdW2lkKj1cIlt2b2NhYnVsYXJ5XVwiXScpO1xuICAgICAgICBpZiAoaHVtYW5pdGFyaWFuU2NvcGVWb2NhYnVsYXJ5Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIC8vIGhpZGUgZmllbGRzIG9uIHBhZ2UgbG9hZFxuICAgICAgICAgICAganF1ZXJ5XzEuZGVmYXVsdC5lYWNoKGh1bWFuaXRhcmlhblNjb3BlVm9jYWJ1bGFyeSwgZnVuY3Rpb24gKGluZGV4LCBzY29wZSkge1xuICAgICAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgICAgICB2YXIgdmFsID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHNjb3BlKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJyc7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZUh1bWFuaXRhcmlhblNjb3BlRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHNjb3BlKSwgdmFsLnRvU3RyaW5nKCkpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAvLyBoaWRlL3Nob3cgZmllbGRzIG9uIHZhbHVlIGNoYW5nZVxuICAgICAgICAgICAgaHVtYW5pdGFyaWFuU2NvcGVWb2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOnNlbGVjdCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIHZhbCA9IGUucGFyYW1zLmRhdGEuaWQ7XG4gICAgICAgICAgICAgICAgdmFyIGluZGV4ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZUh1bWFuaXRhcmlhblNjb3BlRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGluZGV4KSwgdmFsKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgLy8gaGlkZS9zaG93IGZpZWxkcyBvbiB2YWx1ZSBjbGVhclxuICAgICAgICAgICAgaHVtYW5pdGFyaWFuU2NvcGVWb2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgaW5kZXggPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlSHVtYW5pdGFyaWFuU2NvcGVGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaW5kZXgpLCAnJyk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLy8gaGlkZSBjb3VudHJ5IGJ1ZGdldCBiYXNlZCBvbiB2b2NhYnVsYXJ5XG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5oaWRlSHVtYW5pdGFyaWFuU2NvcGVGaWVsZCA9IGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcbiAgICAgICAgdmFyIGh1bWFuaXRhcmlhblNjb3BlSGlkZVZvY2FidWxhcnlVcmkgPSAnaW5wdXRbaWRePVwiaHVtYW5pdGFyaWFuX3Njb3BlXCJdW2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0nO1xuICAgICAgICBpZiAodmFsdWUgPT09ICc5OScpIHtcbiAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAuZmluZChodW1hbml0YXJpYW5TY29wZUhpZGVWb2NhYnVsYXJ5VXJpKVxuICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgfVxuICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAuZmluZChodW1hbml0YXJpYW5TY29wZUhpZGVWb2NhYnVsYXJ5VXJpKVxuICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICogSHVtYW5pdGFyaWFuIFNjb3BlIEZvcm0gUGFnZVxuICAgKlxuICAgKiBATG9naWMgaGlkZSB2b2NhYnVsYXJ5LXVyaSBmaWVsZCBiYXNlZCBvbiAnQHZvY2FidWxhcnknIGZpZWxkIHZhbHVlXG4gICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkVXJpID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuICAgICAgICB2YXIgcmVmZXJlbmNlVm9jYWJ1bGFyeSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnc2VsZWN0W2lkXj1cInJlZmVyZW5jZVwiXVtpZCo9XCJbdm9jYWJ1bGFyeV1cIl0nKTtcbiAgICAgICAgaWYgKHJlZmVyZW5jZVZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAgLy8gaGlkZSBmaWVsZHMgb24gcGFnZSBsb2FkXG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2gocmVmZXJlbmNlVm9jYWJ1bGFyeSwgZnVuY3Rpb24gKGluZGV4LCBzY29wZSkge1xuICAgICAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgICAgICB2YXIgdmFsID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHNjb3BlKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJyc7XG4gICAgICAgICAgICAgICAgX3RoaXMuaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShzY29wZSksIHZhbC50b1N0cmluZygpKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgLy8gaGlkZS9zaG93IGZpZWxkcyBvbiB2YWx1ZSBjaGFuZ2VcbiAgICAgICAgICAgIHJlZmVyZW5jZVZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgdmFsID0gZS5wYXJhbXMuZGF0YS5pZDtcbiAgICAgICAgICAgICAgICB2YXIgaW5kZXggPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5pbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGluZGV4KSwgdmFsKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgLy8gaGlkZS9zaG93IGZpZWxkcyBvbiB2YWx1ZSBjbGVhclxuICAgICAgICAgICAgcmVmZXJlbmNlVm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIGluZGV4ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShpbmRleCksICcnKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvLyBoaWRlIGNvdW50cnkgYnVkZ2V0IGJhc2VkIG9uIHZvY2FidWxhcnlcbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmluZGljYXRvclJlZmVyZW5jZUhpZGVGaWVsZCA9IGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcbiAgICAgICAgdmFyIHJlZmVyZW5jZVVyaSA9ICdpbnB1dFtpZF49XCJyZWZlcmVuY2VcIl1baWQqPVwiW2luZGljYXRvcl91cmldXCJdJztcbiAgICAgICAgaWYgKHZhbHVlID09PSAnOTknKSB7XG4gICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgLmZpbmQocmVmZXJlbmNlVXJpKVxuICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgfVxuICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAuZmluZChyZWZlcmVuY2VVcmkpXG4gICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIENvdW50cnkgQnVkZ2V0IEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIHNob3cvaGlkZSAnY29kZScgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuY291bnRyeUJ1ZGdldEhpZGVDb2RlRmllbGQgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgIHZhciBfYTtcbiAgICAgICAgdmFyIGNvdW50cnlCdWRnZXRWb2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3QjY291bnRyeV9idWRnZXRfdm9jYWJ1bGFyeScpO1xuICAgICAgICBpZiAoY291bnRyeUJ1ZGdldFZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAgLy8gaGlkZS9zaG93IG9uIHBhZ2UgbG9hZFxuICAgICAgICAgICAgdmFyIHZhbCA9IChfYSA9IGNvdW50cnlCdWRnZXRWb2NhYnVsYXJ5LnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnMSc7XG4gICAgICAgICAgICB0aGlzLmhpZGVDb3VudHJ5QnVkZ2V0RmllbGQodmFsLnRvU3RyaW5nKCkpO1xuICAgICAgICAgICAgLy8gaGlkZS9zaG93IG9uIHZhbHVlIGNoYW5nZVxuICAgICAgICAgICAgY291bnRyeUJ1ZGdldFZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgdmFsID0gZS5wYXJhbXMuZGF0YS5pZDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlQ291bnRyeUJ1ZGdldEZpZWxkKHZhbCk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIC8vaGlkZS9zaG93IGJhc2VkIG9uIHZhbHVlIGNsZWFyZWRcbiAgICAgICAgICAgIGNvdW50cnlCdWRnZXRWb2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVDb3VudHJ5QnVkZ2V0RmllbGQoJycpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEhpZGUgQ291bnRyeSBCdWRnZXQgRmllbGRzXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5oaWRlQ291bnRyeUJ1ZGdldEZpZWxkID0gZnVuY3Rpb24gKHZhbHVlKSB7XG4gICAgICAgIHZhciBjb3VudHJ5QnVkZ2V0Q29kZUlucHV0ID0gJ2lucHV0W2lkXj1cImJ1ZGdldF9pdGVtXCJdW2lkKj1cIltjb2RlX3RleHRdXCJdJywgY291bnRyeUJ1ZGdldENvZGVTZWxlY3QgPSAnc2VsZWN0W2lkXj1cImJ1ZGdldF9pdGVtXCJdW2lkKj1cIltjb2RlXVwiXSc7XG4gICAgICAgIGlmICh2YWx1ZSA9PT0gJzEnKSB7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoY291bnRyeUJ1ZGdldENvZGVTZWxlY3QpXG4gICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJykuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShjb3VudHJ5QnVkZ2V0Q29kZUlucHV0KS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJykuc2hvdygpO1xuICAgICAgICB9XG4gICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGNvdW50cnlCdWRnZXRDb2RlU2VsZWN0KS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJykuc2hvdygpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGNvdW50cnlCdWRnZXRDb2RlSW5wdXQpXG4gICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEFpZFR5cGUgRm9ybSBQYWdlXG4gICAgICpcbiAgICAgKiBATG9naWMgaGlkZSB2b2NhYnVsYXJ5LXVyaSBhbmQgY29kZXMgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuYWlkVHlwZVZvY2FidWxhcnlIaWRlRmllbGQgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgIHZhciBhaWR0eXBlX3ZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdFtpZCo9XCJkZWZhdWx0X2FpZF90eXBlX3ZvY2FidWxhcnlcIl0nKTtcbiAgICAgICAgaWYgKGFpZHR5cGVfdm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2goYWlkdHlwZV92b2NhYnVsYXJ5LCBmdW5jdGlvbiAoaW5kZXgsIGl0ZW0pIHtcbiAgICAgICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSAoX2EgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaXRlbSkudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcxJztcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlQWlkVHlwZVNlbGVjdEZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShpdGVtKSwgZGF0YS50b1N0cmluZygpKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgYWlkdHlwZV92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOnNlbGVjdCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSBlLnBhcmFtcy5kYXRhLmlkO1xuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlQWlkVHlwZVNlbGVjdEZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCBkYXRhKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgYWlkdHlwZV92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZUFpZFR5cGVTZWxlY3RGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgJycpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEFpZFR5cGUgRm9ybSBQYWdlXG4gICAgICpcbiAgICAgKiBATG9naWMgaGlkZSB2b2NhYnVsYXJ5LXVyaSBhbmQgY29kZXMgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUudHJhbnNhY3Rpb25BaWRUeXBlVm9jYWJ1bGFyeUhpZGVGaWVsZCA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgdmFyIGFpZHR5cGVfdm9jYWJ1bGFyeSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnc2VsZWN0W2lkKj1cImFpZF90eXBlX3ZvY2FidWxhcnlcIl0nKTtcbiAgICAgICAgaWYgKGFpZHR5cGVfdm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2goYWlkdHlwZV92b2NhYnVsYXJ5LCBmdW5jdGlvbiAoaW5kZXgsIGl0ZW0pIHtcbiAgICAgICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSAoX2EgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaXRlbSkudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcxJztcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlVHJhbnNhY3Rpb25BaWRUeXBlU2VsZWN0RmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGl0ZW0pLCBkYXRhLnRvU3RyaW5nKCkpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICBhaWR0eXBlX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IGUucGFyYW1zLmRhdGEuaWQ7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVUcmFuc2FjdGlvbkFpZFR5cGVTZWxlY3RGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgZGF0YSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIGFpZHR5cGVfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVUcmFuc2FjdGlvbkFpZFR5cGVTZWxlY3RGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgJycpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEhpZGUgQWlkIFR5cGUgU2VsZWN0IEZpZWxkc1xuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaGlkZUFpZFR5cGVTZWxlY3RGaWVsZCA9IGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcbiAgICAgICAgdmFyIGRlZmF1bHRfYWlkX3R5cGUgPSAnc2VsZWN0W2lkKj1cIltkZWZhdWx0X2FpZF90eXBlXVwiXScsIGVhcm1hcmtpbmdfY2F0ZWdvcnkgPSAnc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX2NhdGVnb3J5XVwiXScsIGVhcm1hcmtpbmdfbW9kYWxpdHkgPSAnc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX21vZGFsaXR5XVwiXScsIGNhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllcyA9ICdzZWxlY3RbaWQqPVwiW2Nhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllc11cIl0nLCBjYXNlMSA9ICdzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfY2F0ZWdvcnldXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19tb2RhbGl0eV1cIl0sc2VsZWN0W2lkKj1cIltjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXNdXCJdJywgY2FzZTIgPSAnc2VsZWN0W2lkKj1cIltkZWZhdWx0X2FpZF90eXBlXVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfbW9kYWxpdHldXCJdLHNlbGVjdFtpZCo9XCJbY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzXVwiXScsIGNhc2UzID0gJ3NlbGVjdFtpZCo9XCJbZGVmYXVsdF9haWRfdHlwZV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX2NhdGVnb3J5XVwiXSxzZWxlY3RbaWQqPVwiW2Nhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllc11cIl0nLCBjYXNlNCA9ICdzZWxlY3RbaWQqPVwiW2RlZmF1bHRfYWlkX3R5cGVdXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19jYXRlZ29yeV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX21vZGFsaXR5XVwiXSc7XG4gICAgICAgIHN3aXRjaCAodmFsdWUpIHtcbiAgICAgICAgICAgIGNhc2UgJzInOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGVhcm1hcmtpbmdfY2F0ZWdvcnkpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICczJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChlYXJtYXJraW5nX21vZGFsaXR5KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMylcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnNCc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlNClcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgZGVmYXVsdDpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChkZWZhdWx0X2FpZF90eXBlKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBIaWRlIFRyYW5zYWN0aW9uIEFpZCBUeXBlIFNlbGVjdCBGaWVsZHNcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmhpZGVUcmFuc2FjdGlvbkFpZFR5cGVTZWxlY3RGaWVsZCA9IGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcbiAgICAgICAgdmFyIGFpZF90eXBlID0gJ3NlbGVjdFtpZCo9XCJbYWlkX3R5cGVfY29kZV1cIl0nLCBlYXJtYXJraW5nX2NhdGVnb3J5ID0gJ3NlbGVjdFtpZCo9XCJbZWFybWFya2luZ19jYXRlZ29yeV1cIl0nLCBlYXJtYXJraW5nX21vZGFsaXR5ID0gJ3NlbGVjdFtpZCo9XCJbZWFybWFya2luZ19tb2RhbGl0eV1cIl0nLCBjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXMgPSAnc2VsZWN0W2lkKj1cIltjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXNdXCJdJywgY2FzZTEgPSAnc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX2NhdGVnb3J5XVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfbW9kYWxpdHldXCJdLHNlbGVjdFtpZCo9XCJbY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzXVwiXScsIGNhc2UyID0gJ3NlbGVjdFtpZCo9XCJbYWlkX3R5cGVfY29kZV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX21vZGFsaXR5XVwiXSxzZWxlY3RbaWQqPVwiW2Nhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllc11cIl0nLCBjYXNlMyA9ICdzZWxlY3RbaWQqPVwiW2FpZF90eXBlX2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19jYXRlZ29yeV1cIl0sc2VsZWN0W2lkKj1cIltjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXNdXCJdJywgY2FzZTQgPSAnc2VsZWN0W2lkKj1cIlthaWRfdHlwZV9jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfY2F0ZWdvcnldXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19tb2RhbGl0eV1cIl0nO1xuICAgICAgICBzd2l0Y2ggKHZhbHVlKSB7XG4gICAgICAgICAgICBjYXNlICcyJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChlYXJtYXJraW5nX2NhdGVnb3J5KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMilcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnMyc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoZWFybWFya2luZ19tb2RhbGl0eSlcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTMpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzQnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllcylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTQpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGRlZmF1bHQ6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoYWlkX3R5cGUpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIFBvbGljeSBNYXJrZXIgRm9ybSBQYWdlXG4gICAgICpcbiAgICAgKiBATG9naWMgaGlkZSB2b2NhYnVsYXJ5LXVyaSBhbmQgY29kZXMgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUucG9saWN5Vm9jYWJ1bGFyeUhpZGVGaWVsZCA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgdmFyIHBvbGljeW1ha2VyX3ZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdFtpZCo9XCJwb2xpY3lfbWFya2VyX3ZvY2FidWxhcnlcIl0nKTtcbiAgICAgICAgaWYgKHBvbGljeW1ha2VyX3ZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAganF1ZXJ5XzEuZGVmYXVsdC5lYWNoKHBvbGljeW1ha2VyX3ZvY2FidWxhcnksIGZ1bmN0aW9uIChpbmRleCwgcG9saWN5X21hcmtlcikge1xuICAgICAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShwb2xpY3lfbWFya2VyKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJzEnO1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVQb2xpY3lNYWtlckZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShwb2xpY3lfbWFya2VyKSwgZGF0YS50b1N0cmluZygpKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgcG9saWN5bWFrZXJfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpzZWxlY3QnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gZS5wYXJhbXMuZGF0YS5pZDtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVBvbGljeU1ha2VyRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksIGRhdGEpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICBwb2xpY3ltYWtlcl92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVBvbGljeU1ha2VyRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksICcxJyk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogSGlkZXMgUG9saWN5IE1hcmtlciBGb3JtIEZpZWxkc1xuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaGlkZVBvbGljeU1ha2VyRmllbGQgPSBmdW5jdGlvbiAoaW5kZXgsIHZhbHVlKSB7XG4gICAgICAgIHZhciBjYXNlMV9zaG93ID0gJ3NlbGVjdFtpZCo9XCJbcG9saWN5X21hcmtlcl1cIl0nLCBjYXNlMl9zaG93ID0gJ2lucHV0W2lkKj1cIltwb2xpY3lfbWFya2VyX3RleHRdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0nLCBjYXNlMSA9ICdpbnB1dFtpZCo9XCJbcG9saWN5X21hcmtlcl90ZXh0XVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdJywgY2FzZTIgPSAnc2VsZWN0W2lkKj1cIltwb2xpY3lfbWFya2VyXVwiXSc7XG4gICAgICAgIHN3aXRjaCAodmFsdWUpIHtcbiAgICAgICAgICAgIGNhc2UgJzEnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICc5OSc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTJfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTIpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGRlZmF1bHQ6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTFfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTEpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogU2VjdG9yIEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgYW5kIGNvZGVzIGZpZWxkIGJhc2VkIG9uICdAdm9jYWJ1bGFyeScgZmllbGQgdmFsdWVcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLnNlY3RvclZvY2FidWxhcnlIaWRlRmllbGQgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgIHZhciBzZWN0b3Jfdm9jYWJ1bGFyeSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnc2VsZWN0W2lkKj1cInNlY3Rvcl92b2NhYnVsYXJ5XCJdJyk7XG4gICAgICAgIGlmIChzZWN0b3Jfdm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2goc2VjdG9yX3ZvY2FidWxhcnksIGZ1bmN0aW9uIChpbmRleCwgc2VjdG9yKSB7XG4gICAgICAgICAgICAgICAgdmFyIF9hO1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHNlY3RvcikudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcxJztcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlU2VjdG9yRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHNlY3RvciksIGRhdGEudG9TdHJpbmcoKSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIHNlY3Rvcl92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOnNlbGVjdCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSBlLnBhcmFtcy5kYXRhLmlkO1xuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlU2VjdG9yRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksIGRhdGEpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICBzZWN0b3Jfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVTZWN0b3JGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgJzEnKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBIaWRlIFNlY3RvciBGb3JtIGZpZWxkc1xuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaGlkZVNlY3RvckZpZWxkID0gZnVuY3Rpb24gKGluZGV4LCB2YWx1ZSkge1xuICAgICAgICB2YXIgY2FzZTFfc2hvdyA9ICdzZWxlY3RbaWQqPVwiW2NvZGVdXCJdJywgY2FzZTJfc2hvdyA9ICdzZWxlY3RbaWQqPVwiW2NhdGVnb3J5X2NvZGVdXCJdJywgY2FzZTdfc2hvdyA9ICdzZWxlY3RbaWQqPVwiW3NkZ19nb2FsXVwiXScsIGNhc2U4X3Nob3cgPSAnc2VsZWN0W2lkKj1cIltzZGdfdGFyZ2V0XVwiXScsIGNhc2U5OF85OV9zaG93ID0gJ2lucHV0W2lkKj1cIlt0ZXh0XVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdJywgZGVmYXVsdF9zaG93ID0gJ2lucHV0W2lkKj1cIlt0ZXh0XVwiXScsIGNhc2UxID0gJ3NlbGVjdFtpZCo9XCJbY2F0ZWdvcnlfY29kZV1cIl0sc2VsZWN0W2lkKj1cIltzZGdfZ29hbF1cIl0sc2VsZWN0W2lkKj1cIltzZGdfdGFyZ2V0XVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdLGlucHV0W2lkKj1cIlt0ZXh0XVwiXScsIGNhc2UyID0gJ2lucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0sc2VsZWN0W2lkKj1cIltzZGdfZ29hbF1cIl0sc2VsZWN0W2lkKj1cIltzZGdfdGFyZ2V0XVwiXSxzZWxlY3RbaWQqPVwiW2NvZGVdXCJdLGlucHV0W2lkKj1cIlt0ZXh0XVwiXScsIGNhc2U3ID0gJ2lucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0sc2VsZWN0W2lkKj1cIltjYXRlZ29yeV9jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ190YXJnZXRdXCJdLHNlbGVjdFtpZCo9XCJbY29kZV1cIl0saW5wdXRbaWQqPVwiW3RleHRdXCJdJywgY2FzZTggPSAnaW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSxzZWxlY3RbaWQqPVwiW2NhdGVnb3J5X2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX2dvYWxdXCJdLHNlbGVjdFtpZCo9XCJbY29kZV1cIl0saW5wdXRbaWQqPVwiW3RleHRdXCJdJywgY2FzZTk4Xzk5ID0gJ3NlbGVjdFtpZCo9XCJbY2F0ZWdvcnlfY29kZV1cIl0sc2VsZWN0W2lkKj1cIltzZGdfZ29hbF1cIl0sc2VsZWN0W2lkKj1cIltzZGdfdGFyZ2V0XVwiXSxzZWxlY3RbaWQqPVwiW2NvZGVdXCJdJywgZGVmYXVsdF9oaWRlID0gJ3NlbGVjdFtpZCo9XCJbY2F0ZWdvcnlfY29kZV1cIl0sc2VsZWN0W2lkKj1cIltzZGdfZ29hbF1cIl0sc2VsZWN0W2lkKj1cIltzZGdfdGFyZ2V0XVwiXSxzZWxlY3RbaWQqPVwiW2NvZGVdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0nO1xuICAgICAgICBzd2l0Y2ggKHZhbHVlKSB7XG4gICAgICAgICAgICBjYXNlICcxJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMV9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnMic6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTJfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTIpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzcnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U3X3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U3KVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICc4JzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOF9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOClcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnOTgnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U5OF85OV9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOThfOTkpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzk5JzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOThfOTlfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTk4Xzk5KVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBkZWZhdWx0OlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGRlZmF1bHRfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoZGVmYXVsdF9oaWRlKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqICBSZWNpcGllbnQgVm9jYWJ1bGFyeSBGb3JtIFBhZ2VcbiAgICAgKlxuICAgICAqIEBMb2dpYyBoaWRlIHZvY2FidWxhcnktdXJpIGFuZCBjb2RlcyBmaWVsZCBiYXNlZCBvbiAnQHZvY2FidWxhcnknIGZpZWxkIHZhbHVlXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5yZWNpcGllbnRWb2NhYnVsYXJ5SGlkZUZpZWxkID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuICAgICAgICB2YXIgcmVnaW9uX3ZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdFtpZCo9XCJyZWdpb25fdm9jYWJ1bGFyeVwiXScpO1xuICAgICAgICBpZiAocmVnaW9uX3ZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAganF1ZXJ5XzEuZGVmYXVsdC5lYWNoKHJlZ2lvbl92b2NhYnVsYXJ5LCBmdW5jdGlvbiAoaW5kZXgsIHJlZ2lvbl92b2NhYikge1xuICAgICAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShyZWdpb25fdm9jYWIpLnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnMSc7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVJlY2lwaWVudFJlZ2lvbkZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShyZWdpb25fdm9jYWIpLCBkYXRhLnRvU3RyaW5nKCkpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICByZWdpb25fdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpzZWxlY3QnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gZS5wYXJhbXMuZGF0YS5pZDtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVJlY2lwaWVudFJlZ2lvbkZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCBkYXRhKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgcmVnaW9uX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6Y2xlYXInLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlUmVjaXBpZW50UmVnaW9uRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksICcxJyk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogSGlkZXMgUmVjaXBpZW50IFJlZ2lvbiBGb3JtIEZpZWxkc1xuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaGlkZVJlY2lwaWVudFJlZ2lvbkZpZWxkID0gZnVuY3Rpb24gKGluZGV4LCB2YWx1ZSkge1xuICAgICAgICB2YXIgY2FzZTFfc2hvdyA9ICdzZWxlY3RbaWQqPVwiW3JlZ2lvbl9jb2RlXVwiXScsIGNhc2UyX3Nob3cgPSAnaW5wdXRbaWQqPVwiW2N1c3RvbV9jb2RlXVwiXSwgaW5wdXRbaWQqPVwiW2NvZGVdXCJdJywgY2FzZTk5X3Nob3cgPSAnaW5wdXRbaWQqPVwiW2N1c3RvbV9jb2RlXVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdLCBpbnB1dFtpZCo9XCJbY29kZV1cIl0nLCBjYXNlMSA9ICdpbnB1dFtpZCo9XCJbY3VzdG9tX2NvZGVdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0saW5wdXRbaWQqPVwiW2NvZGVdXCJdJywgY2FzZTIgPSAnc2VsZWN0W2lkKj1cIltyZWdpb25fY29kZV1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXScsIGNhc2U5OSA9ICdzZWxlY3RbaWQqPVwiW3JlZ2lvbl9jb2RlXVwiXSc7XG4gICAgICAgIHN3aXRjaCAodmFsdWUpIHtcbiAgICAgICAgICAgIGNhc2UgJzEnOlxuICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKGNhc2UxX3Nob3cpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICcyJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMl9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMilcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnOTknOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U5OV9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOTkpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGRlZmF1bHQ6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTJfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTIpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogVXBkYXRlcyBBY3Rpdml0eSBpZGVudGlmaWVyXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS51cGRhdGVBY3Rpdml0eUlkZW50aWZpZXIgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBhY3Rpdml0eV9pZGVudGlmaWVyID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjYWN0aXZpdHlfaWRlbnRpZmllcicpO1xuICAgICAgICBpZiAoYWN0aXZpdHlfaWRlbnRpZmllci5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBhY3Rpdml0eV9pZGVudGlmaWVyLm9uKCdrZXl1cCcsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNpYXRpX2lkZW50aWZpZXJfdGV4dCcpLnZhbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5pZGVudGlmaWVyJykuYXR0cignYWN0aXZpdHlfaWRlbnRpZmllcicpICsgXCItXCIuY29uY2F0KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS52YWwoKSkpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIFRhZyBGb3JtIFBhZ2VcbiAgICAgKlxuICAgICAqIEBMb2dpYyBoaWRlIHZvY2FidWxhcnktdXJpIGFuZCBjb2RlcyBmaWVsZCBiYXNlZCBvbiAnQHZvY2FidWxhcnknIGZpZWxkIHZhbHVlXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS50YWdWb2NhYnVsYXJ5SGlkZUZpZWxkID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuICAgICAgICB2YXIgdGFnX3ZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdFtpZCo9XCJ0YWdfdm9jYWJ1bGFyeVwiXScpO1xuICAgICAgICBpZiAodGFnX3ZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAganF1ZXJ5XzEuZGVmYXVsdC5lYWNoKHRhZ192b2NhYnVsYXJ5LCBmdW5jdGlvbiAoaW5kZXgsIHRhZykge1xuICAgICAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YWcpLnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnMSc7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVRhZ0ZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YWcpLCBkYXRhLnRvU3RyaW5nKCkpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICB0YWdfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpzZWxlY3QnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gZS5wYXJhbXMuZGF0YS5pZDtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVRhZ0ZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCBkYXRhKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgdGFnX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6Y2xlYXInLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlVGFnRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksICcxJyk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogSGlkZSBUYWcgRm9ybSBmaWVsZHNcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmhpZGVUYWdGaWVsZCA9IGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcbiAgICAgICAgdmFyIGNhc2UxX3Nob3cgPSAnaW5wdXRbaWQqPVwiW3RhZ190ZXh0XVwiXScsIGNhc2UyX3Nob3cgPSAnc2VsZWN0W2lkKj1cIltnb2Fsc190YWdfY29kZV1cIl0nLCBjYXNlM19zaG93ID0gJ3NlbGVjdFtpZCo9XCJbdGFyZ2V0c190YWdfY29kZV1cIl0nLCBjYXNlOTlfc2hvdyA9ICdpbnB1dFtpZCo9XCJbdGFnX3RleHRdXCJdLCBpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdJywgY2FzZTEgPSAnc2VsZWN0W2lkKj1cIltnb2Fsc190YWdfY29kZV1cIl0sc2VsZWN0W2lkKj1cIlt0YXJnZXRzX3RhZ19jb2RlXVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdJywgY2FzZTIgPSAnaW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSxzZWxlY3RbaWQqPVwiW3RhcmdldHNfdGFnX2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbdGFyZ2V0c190YWdfY29kZV1cIl0saW5wdXRbaWQqPVwiW3RhZ190ZXh0XVwiXScsIGNhc2UzID0gJ2lucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0sc2VsZWN0W2lkKj1cIltnb2Fsc190YWdfY29kZV1cIl0saW5wdXRbaWQqPVwiW3RhZ190ZXh0XVwiXScsIGNhc2U5OSA9ICdzZWxlY3RbaWQqPVwiW2dvYWxzX3RhZ19jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW3RhcmdldHNfdGFnX2NvZGVdXCJdJztcbiAgICAgICAgc3dpdGNoICh2YWx1ZSkge1xuICAgICAgICAgICAgY2FzZSAnMSc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTFfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTEpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzInOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICczJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlM19zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMylcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnOTknOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U5OV9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOTkpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGRlZmF1bHQ6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTFfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTEpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgcmV0dXJuIER5bmFtaWNGaWVsZDtcbn0oKSk7XG5leHBvcnRzLkR5bmFtaWNGaWVsZCA9IER5bmFtaWNGaWVsZDtcbiIsIlwidXNlIHN0cmljdFwiO1xudmFyIF9faW1wb3J0RGVmYXVsdCA9ICh0aGlzICYmIHRoaXMuX19pbXBvcnREZWZhdWx0KSB8fCBmdW5jdGlvbiAobW9kKSB7XG4gICAgcmV0dXJuIChtb2QgJiYgbW9kLl9fZXNNb2R1bGUpID8gbW9kIDogeyBcImRlZmF1bHRcIjogbW9kIH07XG59O1xuT2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFwiX19lc01vZHVsZVwiLCB7IHZhbHVlOiB0cnVlIH0pO1xudmFyIGpxdWVyeV8xID0gX19pbXBvcnREZWZhdWx0KHJlcXVpcmUoXCJqcXVlcnlcIikpO1xucmVxdWlyZShcInNlbGVjdDJcIik7XG52YXIgRHluYW1pY0ZpZWxkXzEgPSByZXF1aXJlKFwiLi9EeW5hbWljRmllbGRcIik7XG52YXIgZHluYW1pY0ZpZWxkID0gbmV3IER5bmFtaWNGaWVsZF8xLkR5bmFtaWNGaWVsZCgpO1xudmFyIEZvcm1CdWlsZGVyID0gLyoqIEBjbGFzcyAqLyAoZnVuY3Rpb24gKCkge1xuICAgIGZ1bmN0aW9uIEZvcm1CdWlsZGVyKCkge1xuICAgIH1cbiAgICAvLyBhZGRzIG5ldyBjb2xsZWN0aW9uIG9mIHN1Yi1lbGVtZW50XG4gICAgRm9ybUJ1aWxkZXIucHJvdG90eXBlLmFkZEZvcm0gPSBmdW5jdGlvbiAoZXYpIHtcbiAgICAgICAgZXYucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgdmFyIHRhcmdldCA9IGV2LnRhcmdldDtcbiAgICAgICAgdmFyIGNvbnRhaW5lciA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2Zvcm1fdHlwZScpXG4gICAgICAgICAgICA/ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShcIi5jb2xsZWN0aW9uLWNvbnRhaW5lcltmb3JtX3R5cGUgPSdcIi5jb25jYXQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignZm9ybV90eXBlJyksIFwiJ11cIikpXG4gICAgICAgICAgICA6ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmNvbGxlY3Rpb24tY29udGFpbmVyJyk7XG4gICAgICAgIHZhciBjb3VudCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2NoaWxkX2NvdW50JylcbiAgICAgICAgICAgID8gcGFyc2VJbnQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignY2hpbGRfY291bnQnKSkgKyAxXG4gICAgICAgICAgICA6ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLnBhcmVudCgpLmZpbmQoJy5mb3JtLWNoaWxkLWJvZHknKS5sZW5ndGg7XG4gICAgICAgIHZhciBwYXJlbnRfY291bnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdwYXJlbnRfY291bnQnKVxuICAgICAgICAgICAgPyBwYXJzZUludCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdwYXJlbnRfY291bnQnKSlcbiAgICAgICAgICAgIDogKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucGFyZW50cygnLm11bHRpLWZvcm0nKS5pbmRleCgpIC0gMTtcbiAgICAgICAgdmFyIHdyYXBwZXJfcGFyZW50X2NvdW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignd3JhcHBlZF9wYXJlbnRfY291bnQnKVxuICAgICAgICAgICAgPyBwYXJzZUludCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCd3cmFwcGVkX3BhcmVudF9jb3VudCcpKVxuICAgICAgICAgICAgOiAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wYXJlbnRzKCcud3JhcHBlZC1jaGlsZC1ib2R5JykuaW5kZXgoKSAtIDE7XG4gICAgICAgIHZhciBwcm90byA9IGNvbnRhaW5lclxuICAgICAgICAgICAgLmRhdGEoJ3Byb3RvdHlwZScpXG4gICAgICAgICAgICAucmVwbGFjZSgvX19QQVJFTlRfTkFNRV9fL2csIHBhcmVudF9jb3VudCk7XG4gICAgICAgIGlmICgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdoYXNfY2hpbGRfY29sbGVjdGlvbicpKSB7XG4gICAgICAgICAgICBwcm90byA9IHByb3RvLnJlcGxhY2UoL19fV1JBUFBFUl9OQU1FX18vZywgY291bnQpO1xuICAgICAgICAgICAgcHJvdG8gPSBwcm90by5yZXBsYWNlKC9fX05BTUVfXy9nLCAwKTtcbiAgICAgICAgfVxuICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgIHByb3RvID0gcHJvdG8ucmVwbGFjZSgvX19OQU1FX18vZywgY291bnQpO1xuICAgICAgICAgICAgcHJvdG8gPSBwcm90by5yZXBsYWNlKC9fX1dSQVBQRVJfTkFNRV9fL2csIHdyYXBwZXJfcGFyZW50X2NvdW50KTtcbiAgICAgICAgfVxuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wcmV2KCkuYXBwZW5kKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShwcm90bykpO1xuICAgICAgICBpZiAoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignaGFzX2NoaWxkX2NvbGxlY3Rpb24nKSkge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldClcbiAgICAgICAgICAgICAgICAucHJldignLnN1YmVsZW1lbnQnKVxuICAgICAgICAgICAgICAgIC5jaGlsZHJlbignLndyYXBwZWQtY2hpbGQtYm9keScpXG4gICAgICAgICAgICAgICAgLmxhc3QoKVxuICAgICAgICAgICAgICAgIC5maW5kKCcuYWRkX3RvX2NvbGxlY3Rpb24nKVxuICAgICAgICAgICAgICAgIC5hdHRyKCd3cmFwcGVkX3BhcmVudF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXG4gICAgICAgICAgICAgICAgLnByZXYoJy5zdWJlbGVtZW50JylcbiAgICAgICAgICAgICAgICAuY2hpbGRyZW4oJy53cmFwcGVkLWNoaWxkLWJvZHknKVxuICAgICAgICAgICAgICAgIC5sYXN0KClcbiAgICAgICAgICAgICAgICAuZmluZCgnLmFkZF90b19jb2xsZWN0aW9uJylcbiAgICAgICAgICAgICAgICAuYXR0cigncGFyZW50X2NvdW50JywgcGFyZW50X2NvdW50KTtcbiAgICAgICAgfVxuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KVxuICAgICAgICAgICAgLnByZXYoKVxuICAgICAgICAgICAgLmZpbmQoJy53cmFwcGVkLWNoaWxkLWJvZHknKVxuICAgICAgICAgICAgLmxhc3QoKVxuICAgICAgICAgICAgLmZpbmQoJy5hZGRfdG9fY29sbGVjdGlvbicpXG4gICAgICAgICAgICAuYXR0cignd3JhcHBlcl9wYXJlbnRfY291bnQnLCB3cmFwcGVyX3BhcmVudF9jb3VudCAhPT0gbnVsbCAmJiB3cmFwcGVyX3BhcmVudF9jb3VudCAhPT0gdm9pZCAwID8gd3JhcHBlcl9wYXJlbnRfY291bnQgOiAwKTtcbiAgICAgICAgaWYgKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2Zvcm1fdHlwZScpKSB7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wcmV2KCkubGFzdCgpLmZpbmQoJy5zZWxlY3QyJykuc2VsZWN0Mih7XG4gICAgICAgICAgICAgICAgcGxhY2Vob2xkZXI6ICdTZWxlY3QgYW4gb3B0aW9uJyxcbiAgICAgICAgICAgICAgICBhbGxvd0NsZWFyOiB0cnVlLFxuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcbiAgICAgICAgICAgICAgICAuZmluZCgnLnN1Yi1hdHRyaWJ1dGUnKVxuICAgICAgICAgICAgICAgIC53cmFwQWxsKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnPGRpdiBjbGFzcz1cImZvcm0tZmllbGQtZ3JvdXAgZmxleCBmbGV4LXdyYXAgcm91bmRlZC1ici1sZyBib3JkZXIteSBib3JkZXItciBib3JkZXItc3ByaW5nLTUwIHN1Yi1hdHRyaWJ1dGUtd3JhcHBlclwiPjwvZGl2PicpKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXG4gICAgICAgICAgICAgICAgLnByZXYoJy5zdWJlbGVtZW50JylcbiAgICAgICAgICAgICAgICAuY2hpbGRyZW4oJy53cmFwcGVkLWNoaWxkLWJvZHknKVxuICAgICAgICAgICAgICAgIC5sYXN0KClcbiAgICAgICAgICAgICAgICAuZmluZCgnLnN1Yi1hdHRyaWJ1dGUnKVxuICAgICAgICAgICAgICAgIC53cmFwQWxsKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnPGRpdiBjbGFzcz1cImZvcm0tZmllbGQtZ3JvdXAgZmxleCBmbGV4LXdyYXAgcm91bmRlZC1ici1sZyBib3JkZXIteSBib3JkZXItciBib3JkZXItc3ByaW5nLTUwIHN1Yi1hdHRyaWJ1dGUtd3JhcHBlciBtdC02XCI+PC9kaXY+JykpO1xuICAgICAgICB9XG4gICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldClcbiAgICAgICAgICAgICAgICAucGFyZW50KClcbiAgICAgICAgICAgICAgICAuZmluZCgnLmZvcm0tY2hpbGQtYm9keScpXG4gICAgICAgICAgICAgICAgLmxhc3QoKVxuICAgICAgICAgICAgICAgIC5maW5kKCcuc2VsZWN0MicpXG4gICAgICAgICAgICAgICAgLnNlbGVjdDIoe1xuICAgICAgICAgICAgICAgIHBsYWNlaG9sZGVyOiAnU2VsZWN0IGFuIG9wdGlvbicsXG4gICAgICAgICAgICAgICAgYWxsb3dDbGVhcjogdHJ1ZSxcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2NoaWxkX2NvdW50JywgY291bnQpO1xuICAgICAgICBkeW5hbWljRmllbGQuYWlkVHlwZVZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgZHluYW1pY0ZpZWxkLnNlY3RvclZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICB9O1xuICAgIC8vIGFkZHMgcGFyZW50IGNvbGxlY3Rpb25cbiAgICBGb3JtQnVpbGRlci5wcm90b3R5cGUuYWRkUGFyZW50Rm9ybSA9IGZ1bmN0aW9uIChldikge1xuICAgICAgICBldi5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICB2YXIgdGFyZ2V0ID0gZXYudGFyZ2V0O1xuICAgICAgICB2YXIgY29udGFpbmVyID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignZm9ybV90eXBlJylcbiAgICAgICAgICAgID8gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKFwiLnBhcmVudC1jb2xsZWN0aW9uW2Zvcm1fdHlwZSA9J1wiLmNvbmNhdCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdmb3JtX3R5cGUnKSwgXCInXVwiKSlcbiAgICAgICAgICAgIDogKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcucGFyZW50LWNvbGxlY3Rpb24nKTtcbiAgICAgICAgdmFyIGNvdW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cigncGFyZW50X2NvdW50JylcbiAgICAgICAgICAgID8gcGFyc2VJbnQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cigncGFyZW50X2NvdW50JykpICsgMVxuICAgICAgICAgICAgOiAoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucHJldigpLmZpbmQoJy5tdWx0aS1mb3JtJykubGVuZ3RoXG4gICAgICAgICAgICAgICAgPyAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wcmV2KCkuZmluZCgnLm11bHRpLWZvcm0nKS5sZW5ndGhcbiAgICAgICAgICAgICAgICA6ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLnByZXYoKS5maW5kKCcud3JhcHBlZC1jaGlsZC1ib2R5JykubGVuZ3RoKSArIDE7XG4gICAgICAgIHZhciBwcm90byA9IGNvbnRhaW5lci5kYXRhKCdwcm90b3R5cGUnKS5yZXBsYWNlKC9fX1BBUkVOVF9OQU1FX18vZywgY291bnQpO1xuICAgICAgICBwcm90byA9IHByb3RvLnJlcGxhY2UoL19fTkFNRV9fL2csIDApO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wcmV2KCkuYXBwZW5kKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShwcm90bykpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wcmV2KCkuZmluZCgnLm11bHRpLWZvcm0nKS5sYXN0KCkuZmluZCgnLnNlbGVjdDInKS5zZWxlY3QyKHtcbiAgICAgICAgICAgIHBsYWNlaG9sZGVyOiAnU2VsZWN0IGFuIG9wdGlvbicsXG4gICAgICAgICAgICBhbGxvd0NsZWFyOiB0cnVlLFxuICAgICAgICB9KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldClcbiAgICAgICAgICAgIC5wcmV2KClcbiAgICAgICAgICAgIC5maW5kKCcubXVsdGktZm9ybScpXG4gICAgICAgICAgICAubGFzdCgpXG4gICAgICAgICAgICAuZmluZCgnLmFkZF90b19jb2xsZWN0aW9uJylcbiAgICAgICAgICAgIC5hdHRyKCdwYXJlbnRfY291bnQnLCBjb3VudCk7XG4gICAgICAgIHRoaXMuYWRkV3JhcHBlck9uQWRkKHRhcmdldCk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ3BhcmVudF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgZHluYW1pY0ZpZWxkLmh1bWFuaXRhcmlhblNjb3BlSGlkZVZvY2FidWxhcnlVcmkoKTtcbiAgICAgICAgZHluYW1pY0ZpZWxkLmNvdW50cnlCdWRnZXRIaWRlQ29kZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC5zZWN0b3JWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC5yZWNpcGllbnRWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC5wb2xpY3lWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC50YWdWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC50cmFuc2FjdGlvbkFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC5pbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGRVcmkoKTtcbiAgICB9O1xuICAgIC8vIGRlbGV0ZXMgY29sbGVjdGlvblxuICAgIEZvcm1CdWlsZGVyLnByb3RvdHlwZS5kZWxldGVGb3JtID0gZnVuY3Rpb24gKGV2KSB7XG4gICAgICAgIGV2LnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIHZhciB0YXJnZXQgPSBldi50YXJnZXQ7XG4gICAgICAgIHZhciBjb2xsZWN0aW9uTGVuZ3RoID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcubXVsdGktZm9ybScpLmxlbmd0aFxuICAgICAgICAgICAgPyAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5jbG9zZXN0KCcuc3ViZWxlbWVudCcpLmZpbmQoJy5mb3JtLWNoaWxkLWJvZHknKS5sZW5ndGhcbiAgICAgICAgICAgIDogKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuZm9ybS1jaGlsZC1ib2R5JykubGVuZ3RoO1xuICAgICAgICB2YXIgY291bnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5hZGRfdG9fY29sbGVjdGlvbicpLmF0dHIoJ2NoaWxkX2NvdW50JylcbiAgICAgICAgICAgID8gcGFyc2VJbnQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX2NvbGxlY3Rpb24nKS5hdHRyKCdjaGlsZF9jb3VudCcpKSArIDFcbiAgICAgICAgICAgIDogY29sbGVjdGlvbkxlbmd0aDtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX2NvbGxlY3Rpb24nKS5hdHRyKCdjaGlsZF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgaWYgKGNvbGxlY3Rpb25MZW5ndGggPiAxKSB7XG4gICAgICAgICAgICB2YXIgdGcgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5jbG9zZXN0KCcuZm9ybS1jaGlsZC1ib2R5Jyk7XG4gICAgICAgICAgICB0Zy5uZXh0KCcuZXJyb3InKS5yZW1vdmUoKTtcbiAgICAgICAgICAgIHRnLnJlbW92ZSgpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvLyBkZWxldGVzIHBhcmVudCBjb2xsZWN0aW9uXG4gICAgRm9ybUJ1aWxkZXIucHJvdG90eXBlLmRlbGV0ZVBhcmVudEZvcm0gPSBmdW5jdGlvbiAoZXYpIHtcbiAgICAgICAgZXYucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgdmFyIHRhcmdldCA9IGV2LnRhcmdldDtcbiAgICAgICAgdmFyIGNvbGxlY3Rpb25MZW5ndGggPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5zdWJlbGVtZW50JykubGVuZ3RoO1xuICAgICAgICB2YXIgY291bnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5hZGRfdG9fcGFyZW50JykuYXR0cignY2hpbGRfY291bnQnKVxuICAgICAgICAgICAgPyBwYXJzZUludCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5hZGRfdG9fcGFyZW50JykuYXR0cignY2hpbGRfY291bnQnKSkgKyAxXG4gICAgICAgICAgICA6IGNvbGxlY3Rpb25MZW5ndGg7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmFkZF90b19wYXJlbnQnKS5hdHRyKCdjaGlsZF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX3BhcmVudCcpLmF0dHIoJ3BhcmVudF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgaWYgKGNvbGxlY3Rpb25MZW5ndGggPiAyKSB7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wYXJlbnQoKS5yZW1vdmUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLy9hZGQgd3JhcHBlciBkaXYgYXJvdW5kIHRoZSBhdHRyaWJ1dGVzXG4gICAgRm9ybUJ1aWxkZXIucHJvdG90eXBlLmFkZFdyYXBwZXIgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLm11bHRpLWZvcm0nKS5lYWNoKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKVxuICAgICAgICAgICAgICAgIC5maW5kKCcuYXR0cmlidXRlJylcbiAgICAgICAgICAgICAgICAud3JhcEFsbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJzxkaXYgY2xhc3M9XCJmb3JtLWZpZWxkLWdyb3VwIGZsZXggZmxleC13cmFwIHJvdW5kZWQtYnItbGcgYm9yZGVyLXkgYm9yZGVyLXIgYm9yZGVyLXNwcmluZy01MCBhdHRyaWJ1dGUtd3JhcHBlciBtYi00XCI+PC9kaXY+JykpO1xuICAgICAgICB9KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuc3ViZWxlbWVudCcpXG4gICAgICAgICAgICAuZmluZCgnLndyYXBwZWQtY2hpbGQtYm9keScpXG4gICAgICAgICAgICAuZWFjaChmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcbiAgICAgICAgICAgICAgICAuZmluZCgnLnN1Yi1hdHRyaWJ1dGUnKVxuICAgICAgICAgICAgICAgIC53cmFwQWxsKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnPGRpdiBjbGFzcz1cImZvcm0tZmllbGQtZ3JvdXAgZmxleCBmbGV4LXdyYXAgcm91bmRlZC1ici1sZyBib3JkZXIteSBib3JkZXItciBib3JkZXItc3ByaW5nLTUwIHN1Yi1hdHRyaWJ1dGUtd3JhcHBlciBtYi00XCI+PC9kaXY+JykpO1xuICAgICAgICB9KTtcbiAgICAgICAgdmFyIGZvcm1GaWVsZCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnZm9ybT4uZm9ybS1maWVsZCcpO1xuICAgICAgICBpZiAoZm9ybUZpZWxkLmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIGZvcm1GaWVsZC53cmFwQWxsKCc8ZGl2IGNsYXNzPVwiZm9ybS1maWVsZC1ncm91cC1vdXRlciBncmlkIHhsOmdyaWQtY29scy0yIG1iLTYgLW14LTMgZ2FwLXktNlwiPjwvZGl2PicpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICBGb3JtQnVpbGRlci5wcm90b3R5cGUuYWRkV3JhcHBlck9uQWRkID0gZnVuY3Rpb24gKHRhcmdldCkge1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KVxuICAgICAgICAgICAgLnByZXYoKVxuICAgICAgICAgICAgLmZpbmQoJy5tdWx0aS1mb3JtJylcbiAgICAgICAgICAgIC5sYXN0KClcbiAgICAgICAgICAgIC5maW5kKCcuYXR0cmlidXRlJylcbiAgICAgICAgICAgIC53cmFwQWxsKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnPGRpdiBjbGFzcz1cImZvcm0tZmllbGQtZ3JvdXAgZ3JpZCB4bDpncmlkLWNvbHMtMiByb3VuZGVkLWJyLWxnIGJvcmRlci15IGJvcmRlci1yIGJvcmRlci1zcHJpbmctNTAgYXR0cmlidXRlLXdyYXBwZXIgbWItNFwiPjwvZGl2PicpKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldClcbiAgICAgICAgICAgIC5wcmV2KClcbiAgICAgICAgICAgIC5maW5kKCcubXVsdGktZm9ybScpXG4gICAgICAgICAgICAubGFzdCgpXG4gICAgICAgICAgICAuZmluZCgnLnN1YmVsZW1lbnQnKVxuICAgICAgICAgICAgLmZpbmQoJy53cmFwcGVkLWNoaWxkLWJvZHknKVxuICAgICAgICAgICAgLmVhY2goZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpXG4gICAgICAgICAgICAgICAgLmZpbmQoJy5zdWItYXR0cmlidXRlJylcbiAgICAgICAgICAgICAgICAud3JhcEFsbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJzxkaXYgY2xhc3M9XCJmb3JtLWZpZWxkLWdyb3VwIGZsZXggZmxleC13cmFwIHJvdW5kZWQtYnItbGcgYm9yZGVyLXkgYm9yZGVyLXIgYm9yZGVyLXNwcmluZy01MCBzdWItYXR0cmlidXRlLXdyYXBwZXIgbWItNFwiPjwvZGl2PicpKTtcbiAgICAgICAgfSk7XG4gICAgfTtcbiAgICBGb3JtQnVpbGRlci5wcm90b3R5cGUudGV4dEFyZWFIZWlnaHQgPSBmdW5jdGlvbiAoZXYpIHtcbiAgICAgICAgdmFyIHRhcmdldCA9IGV2LnRhcmdldDtcbiAgICAgICAgdmFyIGhlaWdodCA9IHRhcmdldC5zY3JvbGxIZWlnaHQ7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmNzcygnaGVpZ2h0JywgaGVpZ2h0KTtcbiAgICB9O1xuICAgIEZvcm1CdWlsZGVyLnByb3RvdHlwZS5hZGRUb0NvbGxlY3Rpb24gPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsICcuYWRkX3RvX2NvbGxlY3Rpb24nLCBmdW5jdGlvbiAoZXZlbnQpIHtcbiAgICAgICAgICAgIGlmICgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoZXZlbnQudGFyZ2V0KS5oYXNDbGFzcygnYWRkLWljb24nKSkge1xuICAgICAgICAgICAgICAgIGV2ZW50LnN0b3BQcm9wYWdhdGlvbigpO1xuICAgICAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShldmVudC50YXJnZXQpLnBhcmVudCgnYnV0dG9uJykudHJpZ2dlcignY2xpY2snKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgICAgIF90aGlzLmFkZEZvcm0oZXZlbnQpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX3BhcmVudCcpLm9uKCdjbGljaycsIGZ1bmN0aW9uIChldmVudCkge1xuICAgICAgICAgICAgaWYgKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShldmVudC50YXJnZXQpLmhhc0NsYXNzKCdhZGQtaWNvbicpKSB7XG4gICAgICAgICAgICAgICAgZXZlbnQuc3RvcFByb3BhZ2F0aW9uKCk7XG4gICAgICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGV2ZW50LnRhcmdldCkucGFyZW50KCdidXR0b24nKS50cmlnZ2VyKCdjbGljaycpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZWxzZSB7XG4gICAgICAgICAgICAgICAgX3RoaXMuYWRkUGFyZW50Rm9ybShldmVudCk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH0pO1xuICAgIH07XG4gICAgRm9ybUJ1aWxkZXIucHJvdG90eXBlLmRlbGV0ZUNvbGxlY3Rpb24gPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgIHZhciBkZWxldGVDb25maXJtYXRpb24gPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5kZWxldGUtY29uZmlybWF0aW9uJyksIGNhbmNlbFBvcHVwID0gJy5jYW5jZWwtcG9wdXAnLCBkZWxldGVDb25maXJtID0gJy5kZWxldGUtY29uZmlybSc7XG4gICAgICAgIHZhciBkZWxldGVJbmRleCA9IHt9LCBjaGlsZE9yUGFyZW50ID0gJyc7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsICcuZGVsZXRlJywgZnVuY3Rpb24gKGV2ZW50KSB7XG4gICAgICAgICAgICBkZWxldGVDb25maXJtYXRpb24uZmFkZUluKCk7XG4gICAgICAgICAgICBkZWxldGVJbmRleCA9IGV2ZW50O1xuICAgICAgICAgICAgY2hpbGRPclBhcmVudCA9ICdjaGlsZCc7XG4gICAgICAgIH0pO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCBjYW5jZWxQb3B1cCwgZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgZGVsZXRlQ29uZmlybWF0aW9uLmZhZGVPdXQoKTtcbiAgICAgICAgICAgIGRlbGV0ZUluZGV4ID0ge307XG4gICAgICAgICAgICBjaGlsZE9yUGFyZW50ID0gJyc7XG4gICAgICAgIH0pO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCBkZWxldGVDb25maXJtLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICBpZiAoY2hpbGRPclBhcmVudCA9PT0gJ2NoaWxkJykge1xuICAgICAgICAgICAgICAgIF90aGlzLmRlbGV0ZUZvcm0oZGVsZXRlSW5kZXgpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZWxzZSBpZiAoY2hpbGRPclBhcmVudCA9PT0gJ3BhcmVudCcpIHtcbiAgICAgICAgICAgICAgICBfdGhpcy5kZWxldGVQYXJlbnRGb3JtKGRlbGV0ZUluZGV4KTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGRlbGV0ZUNvbmZpcm1hdGlvbi5mYWRlT3V0KCk7XG4gICAgICAgICAgICBkZWxldGVJbmRleCA9IHt9O1xuICAgICAgICAgICAgY2hpbGRPclBhcmVudCA9ICcnO1xuICAgICAgICB9KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgJy5kZWxldGUtcGFyZW50JywgZnVuY3Rpb24gKGV2ZW50KSB7XG4gICAgICAgICAgICBkZWxldGVDb25maXJtYXRpb24uZmFkZUluKCk7XG4gICAgICAgICAgICBkZWxldGVJbmRleCA9IGV2ZW50O1xuICAgICAgICAgICAgY2hpbGRPclBhcmVudCA9ICdwYXJlbnQnO1xuICAgICAgICB9KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuc2VsZWN0MicpLnNlbGVjdDIoe1xuICAgICAgICAgICAgcGxhY2Vob2xkZXI6ICdTZWxlY3QgYW4gb3B0aW9uJyxcbiAgICAgICAgICAgIGFsbG93Q2xlYXI6IHRydWUsXG4gICAgICAgIH0pO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2hhbmdlJywgJ2lucHV0W2lkKj1cIltkb2N1bWVudF1cIl0nLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICB2YXIgX2EsIF9iLCBfYztcbiAgICAgICAgICAgIHZhciBlbmRwb2ludCA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmVuZHBvaW50JykuYXR0cignZW5kcG9pbnQnKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJyc7XG4gICAgICAgICAgICB2YXIgZmlsZV9uYW1lID0gKChfYiA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS52YWwoKSkgIT09IG51bGwgJiYgX2IgIT09IHZvaWQgMCA/IF9iIDogJycpLnRvU3RyaW5nKCk7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgIC5maW5kKCdpbnB1dFtpZCo9XCJbdXJsXVwiXScpXG4gICAgICAgICAgICAgICAgLnZhbChcIlwiLmNvbmNhdChlbmRwb2ludCwgXCIvXCIpLmNvbmNhdCgoX2MgPSBmaWxlX25hbWUgPT09IG51bGwgfHwgZmlsZV9uYW1lID09PSB2b2lkIDAgPyB2b2lkIDAgOiBmaWxlX25hbWUuc3BsaXQoJ1xcXFwnKS5wb3AoKSkgPT09IG51bGwgfHwgX2MgPT09IHZvaWQgMCA/IHZvaWQgMCA6IF9jLnJlcGxhY2UoJyAnLCAnXycpKSk7XG4gICAgICAgIH0pO1xuICAgIH07XG4gICAgcmV0dXJuIEZvcm1CdWlsZGVyO1xufSgpKTtcbigwLCBqcXVlcnlfMS5kZWZhdWx0KShmdW5jdGlvbiAoKSB7XG4gICAgdmFyIGZvcm1CdWlsZGVyID0gbmV3IEZvcm1CdWlsZGVyKCk7XG4gICAgZm9ybUJ1aWxkZXIuYWRkV3JhcHBlcigpO1xuICAgIGR5bmFtaWNGaWVsZC5oaWRlU2hvd0Zvcm1GaWVsZHMoKTtcbiAgICBkeW5hbWljRmllbGQudXBkYXRlQWN0aXZpdHlJZGVudGlmaWVyKCk7XG4gICAgZm9ybUJ1aWxkZXIuYWRkVG9Db2xsZWN0aW9uKCk7XG4gICAgZm9ybUJ1aWxkZXIuZGVsZXRlQ29sbGVjdGlvbigpO1xuICAgIC8qKlxuICAgICAqIFRleHQgYXJlYSBoZWlnaHQgb24gdHlwaW5nXG4gICAgICovXG4gICAgdmFyIHRleHRBcmVhVGFyZ2V0ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCd0ZXh0YXJlYS5mb3JtX19pbnB1dCcpO1xuICAgIGlmICh0ZXh0QXJlYVRhcmdldC5sZW5ndGggPiAwKSB7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdpbnB1dCcsICd0ZXh0YXJlYS5mb3JtX19pbnB1dCcsIGZ1bmN0aW9uIChldmVudCkge1xuICAgICAgICAgICAgZm9ybUJ1aWxkZXIudGV4dEFyZWFIZWlnaHQoZXZlbnQpO1xuICAgICAgICB9KTtcbiAgICB9XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ3NlbGVjdDI6b3BlbicsICcuc2VsZWN0MicsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIHNlbGVjdF9zZWFyY2ggPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcuc2VsZWN0Mi1zZWFyY2hfX2ZpZWxkJyk7XG4gICAgICAgIGlmIChzZWxlY3Rfc2VhcmNoKSB7XG4gICAgICAgICAgICBzZWxlY3Rfc2VhcmNoLmZvY3VzKCk7XG4gICAgICAgIH1cbiAgICB9KTtcbiAgICAvKipcbiAgICAgKiBjaGVja3MgcmVnaXN0cmF0aW9uIGFnZW5jeSwgY291bnRyeSBhbmQgcmVnaXN0cmF0aW9uIG51bWJlciB0byBkZWR1Y2UgaWRlbnRpZmllclxuICAgICAqL1xuICAgIHVwZGF0ZVJlZ2lzdHJhdGlvbkFnZW5jeSgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbml6YXRpb25fY291bnRyeScpKTtcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbmlzYXRpb25faWRlbnRpZmllcicpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJyk7XG4gICAgZnVuY3Rpb24gdXBkYXRlUmVnaXN0cmF0aW9uQWdlbmN5KGNvdW50cnkpIHtcbiAgICAgICAgaWYgKGNvdW50cnkudmFsKCkpIHtcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuYWpheCh7IHVybDogJy9vcmdhbmlzYXRpb24vYWdlbmN5LycgKyBjb3VudHJ5LnZhbCgpIH0pLnRoZW4oZnVuY3Rpb24gKHJlc3BvbnNlKSB7XG4gICAgICAgICAgICAgICAgdmFyIF9hO1xuICAgICAgICAgICAgICAgIHZhciBjdXJyZW50X3ZhbCA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI29yZ2FuaXphdGlvbl9yZWdpc3RyYXRpb25fYWdlbmN5JykudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcnO1xuICAgICAgICAgICAgICAgIHZhciB2YWwgPSBmYWxzZTtcbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScpLmVtcHR5KCk7XG4gICAgICAgICAgICAgICAgZm9yICh2YXIgZGF0YSBpbiByZXNwb25zZS5kYXRhKSB7XG4gICAgICAgICAgICAgICAgICAgIGlmIChkYXRhID09PSBjdXJyZW50X3ZhbCkge1xuICAgICAgICAgICAgICAgICAgICAgICAgdmFsID0gdHJ1ZTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScpXG4gICAgICAgICAgICAgICAgICAgICAgICAuYXBwZW5kKG5ldyBPcHRpb24ocmVzcG9uc2UuZGF0YVtkYXRhXSwgZGF0YSwgdHJ1ZSwgdHJ1ZSkpXG4gICAgICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScpXG4gICAgICAgICAgICAgICAgICAgIC52YWwodmFsID8gY3VycmVudF92YWwgOiAnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ3NlbGVjdDI6c2VsZWN0JywgJyNvcmdhbml6YXRpb25fY291bnRyeScsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdXBkYXRlUmVnaXN0cmF0aW9uQWdlbmN5KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKSk7XG4gICAgfSk7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ3NlbGVjdDI6c2VsZWN0JywgJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIGlkZW50aWZpZXIgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykudmFsKCkgKyAnLScgKyAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNyZWdpc3RyYXRpb25fbnVtYmVyJykudmFsKCk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI29yZ2FuaXNhdGlvbl9pZGVudGlmaWVyJykudmFsKGlkZW50aWZpZXIpO1xuICAgIH0pO1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdzZWxlY3QyOmNsZWFyJywgJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIGlkZW50aWZpZXIgPSAnLScgKyAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNyZWdpc3RyYXRpb25fbnVtYmVyJykudmFsKCk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI29yZ2FuaXNhdGlvbl9pZGVudGlmaWVyJykudmFsKGlkZW50aWZpZXIpO1xuICAgIH0pO1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdrZXl1cCcsICcjcmVnaXN0cmF0aW9uX251bWJlcicsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIGlkZW50aWZpZXIgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScpLnZhbCgpICsgJy0nICsgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpLnZhbCgpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbmlzYXRpb25faWRlbnRpZmllcicpLnZhbChpZGVudGlmaWVyKTtcbiAgICB9KTtcbn0pO1xuIl0sIm5hbWVzIjpbIl9faW1wb3J0RGVmYXVsdCIsIm1vZCIsIl9fZXNNb2R1bGUiLCJPYmplY3QiLCJkZWZpbmVQcm9wZXJ0eSIsImV4cG9ydHMiLCJ2YWx1ZSIsIkR5bmFtaWNGaWVsZCIsImpxdWVyeV8xIiwicmVxdWlyZSIsInByb3RvdHlwZSIsImhpZGVTaG93Rm9ybUZpZWxkcyIsImh1bWFuaXRhcmlhblNjb3BlSGlkZVZvY2FidWxhcnlVcmkiLCJjb3VudHJ5QnVkZ2V0SGlkZUNvZGVGaWVsZCIsImFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkIiwic2VjdG9yVm9jYWJ1bGFyeUhpZGVGaWVsZCIsInBvbGljeVZvY2FidWxhcnlIaWRlRmllbGQiLCJyZWNpcGllbnRWb2NhYnVsYXJ5SGlkZUZpZWxkIiwidGFnVm9jYWJ1bGFyeUhpZGVGaWVsZCIsInRyYW5zYWN0aW9uQWlkVHlwZVZvY2FidWxhcnlIaWRlRmllbGQiLCJpbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGRVcmkiLCJfdGhpcyIsImh1bWFuaXRhcmlhblNjb3BlVm9jYWJ1bGFyeSIsImxlbmd0aCIsImVhY2giLCJpbmRleCIsInNjb3BlIiwiX2EiLCJ2YWwiLCJoaWRlSHVtYW5pdGFyaWFuU2NvcGVGaWVsZCIsInRvU3RyaW5nIiwib24iLCJlIiwicGFyYW1zIiwiZGF0YSIsImlkIiwidGFyZ2V0IiwiY2xvc2VzdCIsImZpbmQiLCJzaG93IiwicmVtb3ZlQXR0ciIsInRyaWdnZXIiLCJoaWRlIiwiYXR0ciIsInJlZmVyZW5jZVZvY2FidWxhcnkiLCJpbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGQiLCJyZWZlcmVuY2VVcmkiLCJjb3VudHJ5QnVkZ2V0Vm9jYWJ1bGFyeSIsImhpZGVDb3VudHJ5QnVkZ2V0RmllbGQiLCJjb3VudHJ5QnVkZ2V0Q29kZUlucHV0IiwiY291bnRyeUJ1ZGdldENvZGVTZWxlY3QiLCJhaWR0eXBlX3ZvY2FidWxhcnkiLCJpdGVtIiwiaGlkZUFpZFR5cGVTZWxlY3RGaWVsZCIsImhpZGVUcmFuc2FjdGlvbkFpZFR5cGVTZWxlY3RGaWVsZCIsImRlZmF1bHRfYWlkX3R5cGUiLCJlYXJtYXJraW5nX2NhdGVnb3J5IiwiZWFybWFya2luZ19tb2RhbGl0eSIsImNhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllcyIsImNhc2UxIiwiY2FzZTIiLCJjYXNlMyIsImNhc2U0IiwiYWlkX3R5cGUiLCJwb2xpY3ltYWtlcl92b2NhYnVsYXJ5IiwicG9saWN5X21hcmtlciIsImhpZGVQb2xpY3lNYWtlckZpZWxkIiwiY2FzZTFfc2hvdyIsImNhc2UyX3Nob3ciLCJzZWN0b3Jfdm9jYWJ1bGFyeSIsInNlY3RvciIsImhpZGVTZWN0b3JGaWVsZCIsImNhc2U3X3Nob3ciLCJjYXNlOF9zaG93IiwiY2FzZTk4Xzk5X3Nob3ciLCJkZWZhdWx0X3Nob3ciLCJjYXNlNyIsImNhc2U4IiwiY2FzZTk4Xzk5IiwiZGVmYXVsdF9oaWRlIiwicmVnaW9uX3ZvY2FidWxhcnkiLCJyZWdpb25fdm9jYWIiLCJoaWRlUmVjaXBpZW50UmVnaW9uRmllbGQiLCJjYXNlOTlfc2hvdyIsImNhc2U5OSIsImNvbnNvbGUiLCJsb2ciLCJ1cGRhdGVBY3Rpdml0eUlkZW50aWZpZXIiLCJhY3Rpdml0eV9pZGVudGlmaWVyIiwiY29uY2F0IiwidGFnX3ZvY2FidWxhcnkiLCJ0YWciLCJoaWRlVGFnRmllbGQiLCJjYXNlM19zaG93IiwiRHluYW1pY0ZpZWxkXzEiLCJkeW5hbWljRmllbGQiLCJGb3JtQnVpbGRlciIsImFkZEZvcm0iLCJldiIsInByZXZlbnREZWZhdWx0IiwiY29udGFpbmVyIiwiY291bnQiLCJwYXJzZUludCIsInBhcmVudCIsInBhcmVudF9jb3VudCIsInBhcmVudHMiLCJ3cmFwcGVyX3BhcmVudF9jb3VudCIsInByb3RvIiwicmVwbGFjZSIsInByZXYiLCJhcHBlbmQiLCJjaGlsZHJlbiIsImxhc3QiLCJzZWxlY3QyIiwicGxhY2Vob2xkZXIiLCJhbGxvd0NsZWFyIiwid3JhcEFsbCIsImFkZFBhcmVudEZvcm0iLCJhZGRXcmFwcGVyT25BZGQiLCJkZWxldGVGb3JtIiwiY29sbGVjdGlvbkxlbmd0aCIsInRnIiwibmV4dCIsInJlbW92ZSIsImRlbGV0ZVBhcmVudEZvcm0iLCJhZGRXcmFwcGVyIiwiZm9ybUZpZWxkIiwidGV4dEFyZWFIZWlnaHQiLCJoZWlnaHQiLCJzY3JvbGxIZWlnaHQiLCJjc3MiLCJhZGRUb0NvbGxlY3Rpb24iLCJldmVudCIsImhhc0NsYXNzIiwic3RvcFByb3BhZ2F0aW9uIiwiZGVsZXRlQ29sbGVjdGlvbiIsImRlbGV0ZUNvbmZpcm1hdGlvbiIsImNhbmNlbFBvcHVwIiwiZGVsZXRlQ29uZmlybSIsImRlbGV0ZUluZGV4IiwiY2hpbGRPclBhcmVudCIsImZhZGVJbiIsImZhZGVPdXQiLCJfYiIsIl9jIiwiZW5kcG9pbnQiLCJmaWxlX25hbWUiLCJzcGxpdCIsInBvcCIsImZvcm1CdWlsZGVyIiwidGV4dEFyZWFUYXJnZXQiLCJzZWxlY3Rfc2VhcmNoIiwiZG9jdW1lbnQiLCJxdWVyeVNlbGVjdG9yIiwiZm9jdXMiLCJ1cGRhdGVSZWdpc3RyYXRpb25BZ2VuY3kiLCJjb3VudHJ5IiwiYWpheCIsInVybCIsInRoZW4iLCJyZXNwb25zZSIsImN1cnJlbnRfdmFsIiwiZW1wdHkiLCJPcHRpb24iLCJpZGVudGlmaWVyIl0sInNvdXJjZVJvb3QiOiIifQ==
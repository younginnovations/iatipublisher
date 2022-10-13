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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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QUMsR0FBRzFKLFFBQVEsV0FBWixFQUFzQixtQ0FBdEIsRUFBMkRvQixHQUEzRCxLQUFtRSxHQUFuRSxHQUF5RSxDQUFDLEdBQUdwQixRQUFRLFdBQVosRUFBc0IsSUFBdEIsRUFBNEJvQixHQUE1QixFQUExRjtBQUNBLEtBQUMsR0FBR3BCLFFBQVEsV0FBWixFQUFzQiwwQkFBdEIsRUFBa0RvQixHQUFsRCxDQUFzRHNJLFVBQXREO0FBQ0gsR0FIRDtBQUlILENBaEVEIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9qcy9zY3JpcHRzL0R5bmFtaWNGaWVsZC50cyIsIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2pzL3NjcmlwdHMvZm9ybWJ1aWxkZXIudHMiXSwic291cmNlc0NvbnRlbnQiOlsiXCJ1c2Ugc3RyaWN0XCI7XG52YXIgX19pbXBvcnREZWZhdWx0ID0gKHRoaXMgJiYgdGhpcy5fX2ltcG9ydERlZmF1bHQpIHx8IGZ1bmN0aW9uIChtb2QpIHtcbiAgICByZXR1cm4gKG1vZCAmJiBtb2QuX19lc01vZHVsZSkgPyBtb2QgOiB7IFwiZGVmYXVsdFwiOiBtb2QgfTtcbn07XG5PYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgXCJfX2VzTW9kdWxlXCIsIHsgdmFsdWU6IHRydWUgfSk7XG5leHBvcnRzLkR5bmFtaWNGaWVsZCA9IHZvaWQgMDtcbnZhciBqcXVlcnlfMSA9IF9faW1wb3J0RGVmYXVsdChyZXF1aXJlKFwianF1ZXJ5XCIpKTtcbnJlcXVpcmUoXCJzZWxlY3QyXCIpO1xudmFyIER5bmFtaWNGaWVsZCA9IC8qKiBAY2xhc3MgKi8gKGZ1bmN0aW9uICgpIHtcbiAgICBmdW5jdGlvbiBEeW5hbWljRmllbGQoKSB7XG4gICAgfVxuICAgIC8qKlxuICAgICAqIEhpZGUgYW5kIFNob3cgZGlmZmVyZW50IGZvcm0gZmllbGRzIGJhc2VkIG9uIHZvY2FidWxhcnkgYW5kIG90aGVyIHR5cGVzXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5oaWRlU2hvd0Zvcm1GaWVsZHMgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHRoaXMuaHVtYW5pdGFyaWFuU2NvcGVIaWRlVm9jYWJ1bGFyeVVyaSgpO1xuICAgICAgICB0aGlzLmNvdW50cnlCdWRnZXRIaWRlQ29kZUZpZWxkKCk7XG4gICAgICAgIHRoaXMuYWlkVHlwZVZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgdGhpcy5zZWN0b3JWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIHRoaXMucG9saWN5Vm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICB0aGlzLnJlY2lwaWVudFZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgdGhpcy5zZWN0b3JWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIHRoaXMudGFnVm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICB0aGlzLnRyYW5zYWN0aW9uQWlkVHlwZVZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgdGhpcy5pbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGRVcmkoKTtcbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEh1bWFuaXRhcmlhbiBTY29wZSBGb3JtIFBhZ2VcbiAgICAgKlxuICAgICAqIEBMb2dpYyBoaWRlIHZvY2FidWxhcnktdXJpIGZpZWxkIGJhc2VkIG9uICdAdm9jYWJ1bGFyeScgZmllbGQgdmFsdWVcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmh1bWFuaXRhcmlhblNjb3BlSGlkZVZvY2FidWxhcnlVcmkgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgIHZhciBodW1hbml0YXJpYW5TY29wZVZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdFtpZF49XCJodW1hbml0YXJpYW5fc2NvcGVcIl1baWQqPVwiW3ZvY2FidWxhcnldXCJdJyk7XG4gICAgICAgIGlmIChodW1hbml0YXJpYW5TY29wZVZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAgLy8gaGlkZSBmaWVsZHMgb24gcGFnZSBsb2FkXG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2goaHVtYW5pdGFyaWFuU2NvcGVWb2NhYnVsYXJ5LCBmdW5jdGlvbiAoaW5kZXgsIHNjb3BlKSB7XG4gICAgICAgICAgICAgICAgdmFyIF9hO1xuICAgICAgICAgICAgICAgIHZhciB2YWwgPSAoX2EgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoc2NvcGUpLnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnJztcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlSHVtYW5pdGFyaWFuU2NvcGVGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoc2NvcGUpLCB2YWwudG9TdHJpbmcoKSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIC8vIGhpZGUvc2hvdyBmaWVsZHMgb24gdmFsdWUgY2hhbmdlXG4gICAgICAgICAgICBodW1hbml0YXJpYW5TY29wZVZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgdmFsID0gZS5wYXJhbXMuZGF0YS5pZDtcbiAgICAgICAgICAgICAgICB2YXIgaW5kZXggPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlSHVtYW5pdGFyaWFuU2NvcGVGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaW5kZXgpLCB2YWwpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAvLyBoaWRlL3Nob3cgZmllbGRzIG9uIHZhbHVlIGNsZWFyXG4gICAgICAgICAgICBodW1hbml0YXJpYW5TY29wZVZvY2FidWxhcnkub24oJ3NlbGVjdDI6Y2xlYXInLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciBpbmRleCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVIdW1hbml0YXJpYW5TY29wZUZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShpbmRleCksICcnKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvLyBoaWRlIGNvdW50cnkgYnVkZ2V0IGJhc2VkIG9uIHZvY2FidWxhcnlcbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmhpZGVIdW1hbml0YXJpYW5TY29wZUZpZWxkID0gZnVuY3Rpb24gKGluZGV4LCB2YWx1ZSkge1xuICAgICAgICB2YXIgaHVtYW5pdGFyaWFuU2NvcGVIaWRlVm9jYWJ1bGFyeVVyaSA9ICdpbnB1dFtpZF49XCJodW1hbml0YXJpYW5fc2NvcGVcIl1baWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSc7XG4gICAgICAgIGlmICh2YWx1ZSA9PT0gJzk5Jykge1xuICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgIC5maW5kKGh1bWFuaXRhcmlhblNjb3BlSGlkZVZvY2FidWxhcnlVcmkpXG4gICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICB9XG4gICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgIC5maW5kKGh1bWFuaXRhcmlhblNjb3BlSGlkZVZvY2FidWxhcnlVcmkpXG4gICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgKiBIdW1hbml0YXJpYW4gU2NvcGUgRm9ybSBQYWdlXG4gICAqXG4gICAqIEBMb2dpYyBoaWRlIHZvY2FidWxhcnktdXJpIGZpZWxkIGJhc2VkIG9uICdAdm9jYWJ1bGFyeScgZmllbGQgdmFsdWVcbiAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5pbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGRVcmkgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgIHZhciByZWZlcmVuY2VWb2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3RbaWRePVwicmVmZXJlbmNlXCJdW2lkKj1cIlt2b2NhYnVsYXJ5XVwiXScpO1xuICAgICAgICBpZiAocmVmZXJlbmNlVm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICAvLyBoaWRlIGZpZWxkcyBvbiBwYWdlIGxvYWRcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuZWFjaChyZWZlcmVuY2VWb2NhYnVsYXJ5LCBmdW5jdGlvbiAoaW5kZXgsIHNjb3BlKSB7XG4gICAgICAgICAgICAgICAgdmFyIF9hO1xuICAgICAgICAgICAgICAgIHZhciB2YWwgPSAoX2EgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoc2NvcGUpLnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnJztcbiAgICAgICAgICAgICAgICBfdGhpcy5pbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHNjb3BlKSwgdmFsLnRvU3RyaW5nKCkpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAvLyBoaWRlL3Nob3cgZmllbGRzIG9uIHZhbHVlIGNoYW5nZVxuICAgICAgICAgICAgcmVmZXJlbmNlVm9jYWJ1bGFyeS5vbignc2VsZWN0MjpzZWxlY3QnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciB2YWwgPSBlLnBhcmFtcy5kYXRhLmlkO1xuICAgICAgICAgICAgICAgIHZhciBpbmRleCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmluZGljYXRvclJlZmVyZW5jZUhpZGVGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaW5kZXgpLCB2YWwpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAvLyBoaWRlL3Nob3cgZmllbGRzIG9uIHZhbHVlIGNsZWFyXG4gICAgICAgICAgICByZWZlcmVuY2VWb2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgaW5kZXggPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5pbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGluZGV4KSwgJycpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8vIGhpZGUgY291bnRyeSBidWRnZXQgYmFzZWQgb24gdm9jYWJ1bGFyeVxuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkID0gZnVuY3Rpb24gKGluZGV4LCB2YWx1ZSkge1xuICAgICAgICB2YXIgcmVmZXJlbmNlVXJpID0gJ2lucHV0W2lkXj1cInJlZmVyZW5jZVwiXVtpZCo9XCJbaW5kaWNhdG9yX3VyaV1cIl0nO1xuICAgICAgICBpZiAodmFsdWUgPT09ICc5OScpIHtcbiAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAuZmluZChyZWZlcmVuY2VVcmkpXG4gICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICB9XG4gICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgIC5maW5kKHJlZmVyZW5jZVVyaSlcbiAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogQ291bnRyeSBCdWRnZXQgRm9ybSBQYWdlXG4gICAgICpcbiAgICAgKiBATG9naWMgc2hvdy9oaWRlICdjb2RlJyBmaWVsZCBiYXNlZCBvbiAnQHZvY2FidWxhcnknIGZpZWxkIHZhbHVlXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5jb3VudHJ5QnVkZ2V0SGlkZUNvZGVGaWVsZCA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgdmFyIF9hO1xuICAgICAgICB2YXIgY291bnRyeUJ1ZGdldFZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdCNjb3VudHJ5X2J1ZGdldF92b2NhYnVsYXJ5Jyk7XG4gICAgICAgIGlmIChjb3VudHJ5QnVkZ2V0Vm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICAvLyBoaWRlL3Nob3cgb24gcGFnZSBsb2FkXG4gICAgICAgICAgICB2YXIgdmFsID0gKF9hID0gY291bnRyeUJ1ZGdldFZvY2FidWxhcnkudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcxJztcbiAgICAgICAgICAgIHRoaXMuaGlkZUNvdW50cnlCdWRnZXRGaWVsZCh2YWwudG9TdHJpbmcoKSk7XG4gICAgICAgICAgICAvLyBoaWRlL3Nob3cgb24gdmFsdWUgY2hhbmdlXG4gICAgICAgICAgICBjb3VudHJ5QnVkZ2V0Vm9jYWJ1bGFyeS5vbignc2VsZWN0MjpzZWxlY3QnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciB2YWwgPSBlLnBhcmFtcy5kYXRhLmlkO1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVDb3VudHJ5QnVkZ2V0RmllbGQodmFsKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgLy9oaWRlL3Nob3cgYmFzZWQgb24gdmFsdWUgY2xlYXJlZFxuICAgICAgICAgICAgY291bnRyeUJ1ZGdldFZvY2FidWxhcnkub24oJ3NlbGVjdDI6Y2xlYXInLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZUNvdW50cnlCdWRnZXRGaWVsZCgnJyk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogSGlkZSBDb3VudHJ5IEJ1ZGdldCBGaWVsZHNcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLmhpZGVDb3VudHJ5QnVkZ2V0RmllbGQgPSBmdW5jdGlvbiAodmFsdWUpIHtcbiAgICAgICAgdmFyIGNvdW50cnlCdWRnZXRDb2RlSW5wdXQgPSAnaW5wdXRbaWRePVwiYnVkZ2V0X2l0ZW1cIl1baWQqPVwiW2NvZGVfdGV4dF1cIl0nLCBjb3VudHJ5QnVkZ2V0Q29kZVNlbGVjdCA9ICdzZWxlY3RbaWRePVwiYnVkZ2V0X2l0ZW1cIl1baWQqPVwiW2NvZGVdXCJdJztcbiAgICAgICAgaWYgKHZhbHVlID09PSAnMScpIHtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShjb3VudHJ5QnVkZ2V0Q29kZVNlbGVjdClcbiAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGNvdW50cnlCdWRnZXRDb2RlSW5wdXQpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJykuY2xvc2VzdCgnLmZvcm0tZmllbGQnKS5zaG93KCk7XG4gICAgICAgIH1cbiAgICAgICAgZWxzZSB7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoY291bnRyeUJ1ZGdldENvZGVTZWxlY3QpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJykuY2xvc2VzdCgnLmZvcm0tZmllbGQnKS5zaG93KCk7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoY291bnRyeUJ1ZGdldENvZGVJbnB1dClcbiAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogQWlkVHlwZSBGb3JtIFBhZ2VcbiAgICAgKlxuICAgICAqIEBMb2dpYyBoaWRlIHZvY2FidWxhcnktdXJpIGFuZCBjb2RlcyBmaWVsZCBiYXNlZCBvbiAnQHZvY2FidWxhcnknIGZpZWxkIHZhbHVlXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5haWRUeXBlVm9jYWJ1bGFyeUhpZGVGaWVsZCA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgdmFyIGFpZHR5cGVfdm9jYWJ1bGFyeSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnc2VsZWN0W2lkKj1cImRlZmF1bHRfYWlkX3R5cGVfdm9jYWJ1bGFyeVwiXScpO1xuICAgICAgICBpZiAoYWlkdHlwZV92b2NhYnVsYXJ5Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuZWFjaChhaWR0eXBlX3ZvY2FidWxhcnksIGZ1bmN0aW9uIChpbmRleCwgaXRlbSkge1xuICAgICAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShpdGVtKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJzEnO1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVBaWRUeXBlU2VsZWN0RmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGl0ZW0pLCBkYXRhLnRvU3RyaW5nKCkpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICBhaWR0eXBlX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IGUucGFyYW1zLmRhdGEuaWQ7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVBaWRUeXBlU2VsZWN0RmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksIGRhdGEpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICBhaWR0eXBlX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6Y2xlYXInLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlQWlkVHlwZVNlbGVjdEZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCAnJyk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogQWlkVHlwZSBGb3JtIFBhZ2VcbiAgICAgKlxuICAgICAqIEBMb2dpYyBoaWRlIHZvY2FidWxhcnktdXJpIGFuZCBjb2RlcyBmaWVsZCBiYXNlZCBvbiAnQHZvY2FidWxhcnknIGZpZWxkIHZhbHVlXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS50cmFuc2FjdGlvbkFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuICAgICAgICB2YXIgYWlkdHlwZV92b2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3RbaWQqPVwiYWlkX3R5cGVfdm9jYWJ1bGFyeVwiXScpO1xuICAgICAgICBpZiAoYWlkdHlwZV92b2NhYnVsYXJ5Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuZWFjaChhaWR0eXBlX3ZvY2FidWxhcnksIGZ1bmN0aW9uIChpbmRleCwgaXRlbSkge1xuICAgICAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShpdGVtKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJzEnO1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVUcmFuc2FjdGlvbkFpZFR5cGVTZWxlY3RGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaXRlbSksIGRhdGEudG9TdHJpbmcoKSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIGFpZHR5cGVfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpzZWxlY3QnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gZS5wYXJhbXMuZGF0YS5pZDtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVRyYW5zYWN0aW9uQWlkVHlwZVNlbGVjdEZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCBkYXRhKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgYWlkdHlwZV92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVRyYW5zYWN0aW9uQWlkVHlwZVNlbGVjdEZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCAnJyk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogSGlkZSBBaWQgVHlwZSBTZWxlY3QgRmllbGRzXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5oaWRlQWlkVHlwZVNlbGVjdEZpZWxkID0gZnVuY3Rpb24gKGluZGV4LCB2YWx1ZSkge1xuICAgICAgICB2YXIgZGVmYXVsdF9haWRfdHlwZSA9ICdzZWxlY3RbaWQqPVwiW2RlZmF1bHRfYWlkX3R5cGVdXCJdJywgZWFybWFya2luZ19jYXRlZ29yeSA9ICdzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfY2F0ZWdvcnldXCJdJywgZWFybWFya2luZ19tb2RhbGl0eSA9ICdzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfbW9kYWxpdHldXCJdJywgY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzID0gJ3NlbGVjdFtpZCo9XCJbY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzXVwiXScsIGNhc2UxID0gJ3NlbGVjdFtpZCo9XCJbZWFybWFya2luZ19jYXRlZ29yeV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX21vZGFsaXR5XVwiXSxzZWxlY3RbaWQqPVwiW2Nhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllc11cIl0nLCBjYXNlMiA9ICdzZWxlY3RbaWQqPVwiW2RlZmF1bHRfYWlkX3R5cGVdXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19tb2RhbGl0eV1cIl0sc2VsZWN0W2lkKj1cIltjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXNdXCJdJywgY2FzZTMgPSAnc2VsZWN0W2lkKj1cIltkZWZhdWx0X2FpZF90eXBlXVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfY2F0ZWdvcnldXCJdLHNlbGVjdFtpZCo9XCJbY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzXVwiXScsIGNhc2U0ID0gJ3NlbGVjdFtpZCo9XCJbZGVmYXVsdF9haWRfdHlwZV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX2NhdGVnb3J5XVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfbW9kYWxpdHldXCJdJztcbiAgICAgICAgc3dpdGNoICh2YWx1ZSkge1xuICAgICAgICAgICAgY2FzZSAnMic6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoZWFybWFya2luZ19jYXRlZ29yeSlcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTIpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzMnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGVhcm1hcmtpbmdfbW9kYWxpdHkpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UzKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICc0JzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXMpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U0KVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBkZWZhdWx0OlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGRlZmF1bHRfYWlkX3R5cGUpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEhpZGUgVHJhbnNhY3Rpb24gQWlkIFR5cGUgU2VsZWN0IEZpZWxkc1xuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaGlkZVRyYW5zYWN0aW9uQWlkVHlwZVNlbGVjdEZpZWxkID0gZnVuY3Rpb24gKGluZGV4LCB2YWx1ZSkge1xuICAgICAgICB2YXIgYWlkX3R5cGUgPSAnc2VsZWN0W2lkKj1cIlthaWRfdHlwZV9jb2RlXVwiXScsIGVhcm1hcmtpbmdfY2F0ZWdvcnkgPSAnc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX2NhdGVnb3J5XVwiXScsIGVhcm1hcmtpbmdfbW9kYWxpdHkgPSAnc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX21vZGFsaXR5XVwiXScsIGNhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllcyA9ICdzZWxlY3RbaWQqPVwiW2Nhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllc11cIl0nLCBjYXNlMSA9ICdzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfY2F0ZWdvcnldXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19tb2RhbGl0eV1cIl0sc2VsZWN0W2lkKj1cIltjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXNdXCJdJywgY2FzZTIgPSAnc2VsZWN0W2lkKj1cIlthaWRfdHlwZV9jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfbW9kYWxpdHldXCJdLHNlbGVjdFtpZCo9XCJbY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzXVwiXScsIGNhc2UzID0gJ3NlbGVjdFtpZCo9XCJbYWlkX3R5cGVfY29kZV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX2NhdGVnb3J5XVwiXSxzZWxlY3RbaWQqPVwiW2Nhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllc11cIl0nLCBjYXNlNCA9ICdzZWxlY3RbaWQqPVwiW2FpZF90eXBlX2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19jYXRlZ29yeV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX21vZGFsaXR5XVwiXSc7XG4gICAgICAgIHN3aXRjaCAodmFsdWUpIHtcbiAgICAgICAgICAgIGNhc2UgJzInOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGVhcm1hcmtpbmdfY2F0ZWdvcnkpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICczJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChlYXJtYXJraW5nX21vZGFsaXR5KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMylcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnNCc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlNClcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgZGVmYXVsdDpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChhaWRfdHlwZSlcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTEpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogUG9saWN5IE1hcmtlciBGb3JtIFBhZ2VcbiAgICAgKlxuICAgICAqIEBMb2dpYyBoaWRlIHZvY2FidWxhcnktdXJpIGFuZCBjb2RlcyBmaWVsZCBiYXNlZCBvbiAnQHZvY2FidWxhcnknIGZpZWxkIHZhbHVlXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5wb2xpY3lWb2NhYnVsYXJ5SGlkZUZpZWxkID0gZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuICAgICAgICB2YXIgcG9saWN5bWFrZXJfdm9jYWJ1bGFyeSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnc2VsZWN0W2lkKj1cInBvbGljeV9tYXJrZXJfdm9jYWJ1bGFyeVwiXScpO1xuICAgICAgICBpZiAocG9saWN5bWFrZXJfdm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2gocG9saWN5bWFrZXJfdm9jYWJ1bGFyeSwgZnVuY3Rpb24gKGluZGV4LCBwb2xpY3lfbWFya2VyKSB7XG4gICAgICAgICAgICAgICAgdmFyIF9hO1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHBvbGljeV9tYXJrZXIpLnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnMSc7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVBvbGljeU1ha2VyRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHBvbGljeV9tYXJrZXIpLCBkYXRhLnRvU3RyaW5nKCkpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICBwb2xpY3ltYWtlcl92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOnNlbGVjdCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSBlLnBhcmFtcy5kYXRhLmlkO1xuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlUG9saWN5TWFrZXJGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgZGF0YSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIHBvbGljeW1ha2VyX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6Y2xlYXInLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlUG9saWN5TWFrZXJGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgJzEnKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBIaWRlcyBQb2xpY3kgTWFya2VyIEZvcm0gRmllbGRzXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5oaWRlUG9saWN5TWFrZXJGaWVsZCA9IGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcbiAgICAgICAgdmFyIGNhc2UxX3Nob3cgPSAnc2VsZWN0W2lkKj1cIltwb2xpY3lfbWFya2VyXVwiXScsIGNhc2UyX3Nob3cgPSAnaW5wdXRbaWQqPVwiW3BvbGljeV9tYXJrZXJfdGV4dF1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXScsIGNhc2UxID0gJ2lucHV0W2lkKj1cIltwb2xpY3lfbWFya2VyX3RleHRdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0nLCBjYXNlMiA9ICdzZWxlY3RbaWQqPVwiW3BvbGljeV9tYXJrZXJdXCJdJztcbiAgICAgICAgc3dpdGNoICh2YWx1ZSkge1xuICAgICAgICAgICAgY2FzZSAnMSc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTFfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTEpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzk5JzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMl9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMilcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgZGVmYXVsdDpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMV9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBTZWN0b3IgRm9ybSBQYWdlXG4gICAgICpcbiAgICAgKiBATG9naWMgaGlkZSB2b2NhYnVsYXJ5LXVyaSBhbmQgY29kZXMgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuc2VjdG9yVm9jYWJ1bGFyeUhpZGVGaWVsZCA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIF90aGlzID0gdGhpcztcbiAgICAgICAgdmFyIHNlY3Rvcl92b2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3RbaWQqPVwic2VjdG9yX3ZvY2FidWxhcnlcIl0nKTtcbiAgICAgICAgaWYgKHNlY3Rvcl92b2NhYnVsYXJ5Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuZWFjaChzZWN0b3Jfdm9jYWJ1bGFyeSwgZnVuY3Rpb24gKGluZGV4LCBzZWN0b3IpIHtcbiAgICAgICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSAoX2EgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoc2VjdG9yKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJzEnO1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVTZWN0b3JGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoc2VjdG9yKSwgZGF0YS50b1N0cmluZygpKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgc2VjdG9yX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IGUucGFyYW1zLmRhdGEuaWQ7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVTZWN0b3JGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgZGF0YSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIHNlY3Rvcl92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgX3RoaXMuaGlkZVNlY3RvckZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCAnMScpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEhpZGUgU2VjdG9yIEZvcm0gZmllbGRzXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5oaWRlU2VjdG9yRmllbGQgPSBmdW5jdGlvbiAoaW5kZXgsIHZhbHVlKSB7XG4gICAgICAgIHZhciBjYXNlMV9zaG93ID0gJ3NlbGVjdFtpZCo9XCJbY29kZV1cIl0nLCBjYXNlMl9zaG93ID0gJ3NlbGVjdFtpZCo9XCJbY2F0ZWdvcnlfY29kZV1cIl0nLCBjYXNlN19zaG93ID0gJ3NlbGVjdFtpZCo9XCJbc2RnX2dvYWxdXCJdJywgY2FzZThfc2hvdyA9ICdzZWxlY3RbaWQqPVwiW3NkZ190YXJnZXRdXCJdJywgY2FzZTk4Xzk5X3Nob3cgPSAnaW5wdXRbaWQqPVwiW3RleHRdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0nLCBkZWZhdWx0X3Nob3cgPSAnaW5wdXRbaWQqPVwiW3RleHRdXCJdJywgY2FzZTEgPSAnc2VsZWN0W2lkKj1cIltjYXRlZ29yeV9jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ19nb2FsXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ190YXJnZXRdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0saW5wdXRbaWQqPVwiW3RleHRdXCJdJywgY2FzZTIgPSAnaW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ19nb2FsXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ190YXJnZXRdXCJdLHNlbGVjdFtpZCo9XCJbY29kZV1cIl0saW5wdXRbaWQqPVwiW3RleHRdXCJdJywgY2FzZTcgPSAnaW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSxzZWxlY3RbaWQqPVwiW2NhdGVnb3J5X2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX3RhcmdldF1cIl0sc2VsZWN0W2lkKj1cIltjb2RlXVwiXSxpbnB1dFtpZCo9XCJbdGV4dF1cIl0nLCBjYXNlOCA9ICdpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdLHNlbGVjdFtpZCo9XCJbY2F0ZWdvcnlfY29kZV1cIl0sc2VsZWN0W2lkKj1cIltzZGdfZ29hbF1cIl0sc2VsZWN0W2lkKj1cIltjb2RlXVwiXSxpbnB1dFtpZCo9XCJbdGV4dF1cIl0nLCBjYXNlOThfOTkgPSAnc2VsZWN0W2lkKj1cIltjYXRlZ29yeV9jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ19nb2FsXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ190YXJnZXRdXCJdLHNlbGVjdFtpZCo9XCJbY29kZV1cIl0nLCBkZWZhdWx0X2hpZGUgPSAnc2VsZWN0W2lkKj1cIltjYXRlZ29yeV9jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ19nb2FsXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ190YXJnZXRdXCJdLHNlbGVjdFtpZCo9XCJbY29kZV1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSc7XG4gICAgICAgIHN3aXRjaCAodmFsdWUpIHtcbiAgICAgICAgICAgIGNhc2UgJzEnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICcyJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMl9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMilcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnNyc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTdfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTcpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzgnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U4X3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U4KVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICc5OCc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTk4Xzk5X3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U5OF85OSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnOTknOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U5OF85OV9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlOThfOTkpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGRlZmF1bHQ6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoZGVmYXVsdF9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChkZWZhdWx0X2hpZGUpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogIFJlY2lwaWVudCBWb2NhYnVsYXJ5IEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgYW5kIGNvZGVzIGZpZWxkIGJhc2VkIG9uICdAdm9jYWJ1bGFyeScgZmllbGQgdmFsdWVcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLnJlY2lwaWVudFZvY2FidWxhcnlIaWRlRmllbGQgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgIHZhciByZWdpb25fdm9jYWJ1bGFyeSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnc2VsZWN0W2lkKj1cInJlZ2lvbl92b2NhYnVsYXJ5XCJdJyk7XG4gICAgICAgIGlmIChyZWdpb25fdm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2gocmVnaW9uX3ZvY2FidWxhcnksIGZ1bmN0aW9uIChpbmRleCwgcmVnaW9uX3ZvY2FiKSB7XG4gICAgICAgICAgICAgICAgdmFyIF9hO1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHJlZ2lvbl92b2NhYikudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcxJztcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlUmVjaXBpZW50UmVnaW9uRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHJlZ2lvbl92b2NhYiksIGRhdGEudG9TdHJpbmcoKSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIHJlZ2lvbl92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOnNlbGVjdCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSBlLnBhcmFtcy5kYXRhLmlkO1xuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlUmVjaXBpZW50UmVnaW9uRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksIGRhdGEpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICByZWdpb25fdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVSZWNpcGllbnRSZWdpb25GaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgJzEnKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBIaWRlcyBSZWNpcGllbnQgUmVnaW9uIEZvcm0gRmllbGRzXG4gICAgICovXG4gICAgRHluYW1pY0ZpZWxkLnByb3RvdHlwZS5oaWRlUmVjaXBpZW50UmVnaW9uRmllbGQgPSBmdW5jdGlvbiAoaW5kZXgsIHZhbHVlKSB7XG4gICAgICAgIHZhciBjYXNlMV9zaG93ID0gJ3NlbGVjdFtpZCo9XCJbcmVnaW9uX2NvZGVdXCJdJywgY2FzZTJfc2hvdyA9ICdpbnB1dFtpZCo9XCJbY3VzdG9tX2NvZGVdXCJdLCBpbnB1dFtpZCo9XCJbY29kZV1cIl0nLCBjYXNlOTlfc2hvdyA9ICdpbnB1dFtpZCo9XCJbY3VzdG9tX2NvZGVdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0sIGlucHV0W2lkKj1cIltjb2RlXVwiXScsIGNhc2UxID0gJ2lucHV0W2lkKj1cIltjdXN0b21fY29kZV1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSxpbnB1dFtpZCo9XCJbY29kZV1cIl0nLCBjYXNlMiA9ICdzZWxlY3RbaWQqPVwiW3JlZ2lvbl9jb2RlXVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdJywgY2FzZTk5ID0gJ3NlbGVjdFtpZCo9XCJbcmVnaW9uX2NvZGVdXCJdJztcbiAgICAgICAgc3dpdGNoICh2YWx1ZSkge1xuICAgICAgICAgICAgY2FzZSAnMSc6XG4gICAgICAgICAgICAgICAgY29uc29sZS5sb2coY2FzZTFfc2hvdyk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTFfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTEpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzInOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICc5OSc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTk5X3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U5OSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgZGVmYXVsdDpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMl9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMilcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBVcGRhdGVzIEFjdGl2aXR5IGlkZW50aWZpZXJcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLnVwZGF0ZUFjdGl2aXR5SWRlbnRpZmllciA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIGFjdGl2aXR5X2lkZW50aWZpZXIgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNhY3Rpdml0eV9pZGVudGlmaWVyJyk7XG4gICAgICAgIGlmIChhY3Rpdml0eV9pZGVudGlmaWVyLmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIGFjdGl2aXR5X2lkZW50aWZpZXIub24oJ2tleXVwJywgZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI2lhdGlfaWRlbnRpZmllcl90ZXh0JykudmFsKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmlkZW50aWZpZXInKS5hdHRyKCdhY3Rpdml0eV9pZGVudGlmaWVyJykgKyBcIi1cIi5jb25jYXQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpLnZhbCgpKSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLyoqXG4gICAgICogVGFnIEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgYW5kIGNvZGVzIGZpZWxkIGJhc2VkIG9uICdAdm9jYWJ1bGFyeScgZmllbGQgdmFsdWVcbiAgICAgKi9cbiAgICBEeW5hbWljRmllbGQucHJvdG90eXBlLnRhZ1ZvY2FidWxhcnlIaWRlRmllbGQgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgIHZhciB0YWdfdm9jYWJ1bGFyeSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnc2VsZWN0W2lkKj1cInRhZ192b2NhYnVsYXJ5XCJdJyk7XG4gICAgICAgIGlmICh0YWdfdm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2godGFnX3ZvY2FidWxhcnksIGZ1bmN0aW9uIChpbmRleCwgdGFnKSB7XG4gICAgICAgICAgICAgICAgdmFyIF9hO1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhZykudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcxJztcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlVGFnRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhZyksIGRhdGEudG9TdHJpbmcoKSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIHRhZ192b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOnNlbGVjdCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSBlLnBhcmFtcy5kYXRhLmlkO1xuICAgICAgICAgICAgICAgIHZhciB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICBfdGhpcy5oaWRlVGFnRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksIGRhdGEpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICB0YWdfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICAgdmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIF90aGlzLmhpZGVUYWdGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgJzEnKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBIaWRlIFRhZyBGb3JtIGZpZWxkc1xuICAgICAqL1xuICAgIER5bmFtaWNGaWVsZC5wcm90b3R5cGUuaGlkZVRhZ0ZpZWxkID0gZnVuY3Rpb24gKGluZGV4LCB2YWx1ZSkge1xuICAgICAgICB2YXIgY2FzZTFfc2hvdyA9ICdpbnB1dFtpZCo9XCJbdGFnX3RleHRdXCJdJywgY2FzZTJfc2hvdyA9ICdzZWxlY3RbaWQqPVwiW2dvYWxzX3RhZ19jb2RlXVwiXScsIGNhc2UzX3Nob3cgPSAnc2VsZWN0W2lkKj1cIlt0YXJnZXRzX3RhZ19jb2RlXVwiXScsIGNhc2U5OV9zaG93ID0gJ2lucHV0W2lkKj1cIlt0YWdfdGV4dF1cIl0sIGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0nLCBjYXNlMSA9ICdzZWxlY3RbaWQqPVwiW2dvYWxzX3RhZ19jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW3RhcmdldHNfdGFnX2NvZGVdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0nLCBjYXNlMiA9ICdpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdLHNlbGVjdFtpZCo9XCJbdGFyZ2V0c190YWdfY29kZV1cIl0sc2VsZWN0W2lkKj1cIlt0YXJnZXRzX3RhZ19jb2RlXVwiXSxpbnB1dFtpZCo9XCJbdGFnX3RleHRdXCJdJywgY2FzZTMgPSAnaW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSxzZWxlY3RbaWQqPVwiW2dvYWxzX3RhZ19jb2RlXVwiXSxpbnB1dFtpZCo9XCJbdGFnX3RleHRdXCJdJywgY2FzZTk5ID0gJ3NlbGVjdFtpZCo9XCJbZ29hbHNfdGFnX2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbdGFyZ2V0c190YWdfY29kZV1cIl0nO1xuICAgICAgICBzd2l0Y2ggKHZhbHVlKSB7XG4gICAgICAgICAgICBjYXNlICcxJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMV9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnMic6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTJfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTIpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzMnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UzX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UzKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICc5OSc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTk5X3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCkucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U5OSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgZGVmYXVsdDpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMV9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCkuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICByZXR1cm4gRHluYW1pY0ZpZWxkO1xufSgpKTtcbmV4cG9ydHMuRHluYW1pY0ZpZWxkID0gRHluYW1pY0ZpZWxkO1xuIiwiXCJ1c2Ugc3RyaWN0XCI7XG52YXIgX19pbXBvcnREZWZhdWx0ID0gKHRoaXMgJiYgdGhpcy5fX2ltcG9ydERlZmF1bHQpIHx8IGZ1bmN0aW9uIChtb2QpIHtcbiAgICByZXR1cm4gKG1vZCAmJiBtb2QuX19lc01vZHVsZSkgPyBtb2QgOiB7IFwiZGVmYXVsdFwiOiBtb2QgfTtcbn07XG5PYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgXCJfX2VzTW9kdWxlXCIsIHsgdmFsdWU6IHRydWUgfSk7XG52YXIganF1ZXJ5XzEgPSBfX2ltcG9ydERlZmF1bHQocmVxdWlyZShcImpxdWVyeVwiKSk7XG5yZXF1aXJlKFwic2VsZWN0MlwiKTtcbnZhciBEeW5hbWljRmllbGRfMSA9IHJlcXVpcmUoXCIuL0R5bmFtaWNGaWVsZFwiKTtcbnZhciBkeW5hbWljRmllbGQgPSBuZXcgRHluYW1pY0ZpZWxkXzEuRHluYW1pY0ZpZWxkKCk7XG52YXIgRm9ybUJ1aWxkZXIgPSAvKiogQGNsYXNzICovIChmdW5jdGlvbiAoKSB7XG4gICAgZnVuY3Rpb24gRm9ybUJ1aWxkZXIoKSB7XG4gICAgfVxuICAgIC8vIGFkZHMgbmV3IGNvbGxlY3Rpb24gb2Ygc3ViLWVsZW1lbnRcbiAgICBGb3JtQnVpbGRlci5wcm90b3R5cGUuYWRkRm9ybSA9IGZ1bmN0aW9uIChldikge1xuICAgICAgICBldi5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICB2YXIgdGFyZ2V0ID0gZXYudGFyZ2V0O1xuICAgICAgICB2YXIgY29udGFpbmVyID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignZm9ybV90eXBlJylcbiAgICAgICAgICAgID8gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKFwiLmNvbGxlY3Rpb24tY29udGFpbmVyW2Zvcm1fdHlwZSA9J1wiLmNvbmNhdCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdmb3JtX3R5cGUnKSwgXCInXVwiKSlcbiAgICAgICAgICAgIDogKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuY29sbGVjdGlvbi1jb250YWluZXInKTtcbiAgICAgICAgdmFyIGNvdW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignY2hpbGRfY291bnQnKVxuICAgICAgICAgICAgPyBwYXJzZUludCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdjaGlsZF9jb3VudCcpKSArIDFcbiAgICAgICAgICAgIDogKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucGFyZW50KCkuZmluZCgnLmZvcm0tY2hpbGQtYm9keScpLmxlbmd0aDtcbiAgICAgICAgdmFyIHBhcmVudF9jb3VudCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ3BhcmVudF9jb3VudCcpXG4gICAgICAgICAgICA/IHBhcnNlSW50KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ3BhcmVudF9jb3VudCcpKVxuICAgICAgICAgICAgOiAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wYXJlbnQoJy5zdWJlbGVtZW50JykucHJldkFsbCgnLm11bHRpLWZvcm0nKS5sZW5ndGg7XG4gICAgICAgIHZhciB3cmFwcGVyX3BhcmVudF9jb3VudCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ3dyYXBwZWRfcGFyZW50X2NvdW50JylcbiAgICAgICAgICAgID8gcGFyc2VJbnQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignd3JhcHBlZF9wYXJlbnRfY291bnQnKSlcbiAgICAgICAgICAgIDogKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucGFyZW50KCcuc3ViZWxlbWVudCcpLmZpbmQoJy53cmFwcGVkLWNoaWxkLWJvZHknKS5sZW5ndGg7XG4gICAgICAgIHZhciBwcm90byA9IGNvbnRhaW5lclxuICAgICAgICAgICAgLmRhdGEoJ3Byb3RvdHlwZScpXG4gICAgICAgICAgICAucmVwbGFjZSgvX19QQVJFTlRfTkFNRV9fL2csIHBhcmVudF9jb3VudCk7XG4gICAgICAgIGlmICgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdoYXNfY2hpbGRfY29sbGVjdGlvbicpKSB7XG4gICAgICAgICAgICBwcm90byA9IHByb3RvLnJlcGxhY2UoL19fV1JBUFBFUl9OQU1FX18vZywgY291bnQpO1xuICAgICAgICAgICAgcHJvdG8gPSBwcm90by5yZXBsYWNlKC9fX05BTUVfXy9nLCAwKTtcbiAgICAgICAgfVxuICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgIHByb3RvID0gcHJvdG8ucmVwbGFjZSgvX19OQU1FX18vZywgY291bnQpO1xuICAgICAgICAgICAgcHJvdG8gPSBwcm90by5yZXBsYWNlKC9fX1dSQVBQRVJfTkFNRV9fL2csIHdyYXBwZXJfcGFyZW50X2NvdW50KTtcbiAgICAgICAgfVxuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wcmV2KCkuYXBwZW5kKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShwcm90bykpO1xuICAgICAgICBpZiAoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignaGFzX2NoaWxkX2NvbGxlY3Rpb24nKSkge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldClcbiAgICAgICAgICAgICAgICAucHJldignLnN1YmVsZW1lbnQnKVxuICAgICAgICAgICAgICAgIC5jaGlsZHJlbignLndyYXBwZWQtY2hpbGQtYm9keScpXG4gICAgICAgICAgICAgICAgLmxhc3QoKVxuICAgICAgICAgICAgICAgIC5maW5kKCcuYWRkX3RvX2NvbGxlY3Rpb24nKVxuICAgICAgICAgICAgICAgIC5hdHRyKCd3cmFwcGVkX3BhcmVudF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXG4gICAgICAgICAgICAgICAgLnByZXYoJy5zdWJlbGVtZW50JylcbiAgICAgICAgICAgICAgICAuY2hpbGRyZW4oJy53cmFwcGVkLWNoaWxkLWJvZHknKVxuICAgICAgICAgICAgICAgIC5sYXN0KClcbiAgICAgICAgICAgICAgICAuZmluZCgnLmFkZF90b19jb2xsZWN0aW9uJylcbiAgICAgICAgICAgICAgICAuYXR0cigncGFyZW50X2NvdW50JywgcGFyZW50X2NvdW50KTtcbiAgICAgICAgfVxuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KVxuICAgICAgICAgICAgLnByZXYoKVxuICAgICAgICAgICAgLmZpbmQoJy53cmFwcGVkLWNoaWxkLWJvZHknKVxuICAgICAgICAgICAgLmxhc3QoKVxuICAgICAgICAgICAgLmZpbmQoJy5hZGRfdG9fY29sbGVjdGlvbicpXG4gICAgICAgICAgICAuYXR0cignd3JhcHBlcl9wYXJlbnRfY291bnQnLCB3cmFwcGVyX3BhcmVudF9jb3VudCAhPT0gbnVsbCAmJiB3cmFwcGVyX3BhcmVudF9jb3VudCAhPT0gdm9pZCAwID8gd3JhcHBlcl9wYXJlbnRfY291bnQgOiAwKTtcbiAgICAgICAgaWYgKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2Zvcm1fdHlwZScpKSB7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wcmV2KCkubGFzdCgpLmZpbmQoJy5zZWxlY3QyJykuc2VsZWN0Mih7XG4gICAgICAgICAgICAgICAgcGxhY2Vob2xkZXI6ICdTZWxlY3QgYW4gb3B0aW9uJyxcbiAgICAgICAgICAgICAgICBhbGxvd0NsZWFyOiB0cnVlLFxuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcbiAgICAgICAgICAgICAgICAuZmluZCgnLnN1Yi1hdHRyaWJ1dGUnKVxuICAgICAgICAgICAgICAgIC53cmFwQWxsKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnPGRpdiBjbGFzcz1cImZvcm0tZmllbGQtZ3JvdXAgZmxleCBmbGV4LXdyYXAgcm91bmRlZC1ici1sZyBib3JkZXIteSBib3JkZXItciBib3JkZXItc3ByaW5nLTUwIHN1Yi1hdHRyaWJ1dGUtd3JhcHBlclwiPjwvZGl2PicpKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXG4gICAgICAgICAgICAgICAgLnByZXYoJy5zdWJlbGVtZW50JylcbiAgICAgICAgICAgICAgICAuY2hpbGRyZW4oJy53cmFwcGVkLWNoaWxkLWJvZHknKVxuICAgICAgICAgICAgICAgIC5sYXN0KClcbiAgICAgICAgICAgICAgICAuZmluZCgnLnN1Yi1hdHRyaWJ1dGUnKVxuICAgICAgICAgICAgICAgIC53cmFwQWxsKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnPGRpdiBjbGFzcz1cImZvcm0tZmllbGQtZ3JvdXAgZmxleCBmbGV4LXdyYXAgcm91bmRlZC1ici1sZyBib3JkZXIteSBib3JkZXItciBib3JkZXItc3ByaW5nLTUwIHN1Yi1hdHRyaWJ1dGUtd3JhcHBlciBtdC02XCI+PC9kaXY+JykpO1xuICAgICAgICB9XG4gICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldClcbiAgICAgICAgICAgICAgICAucGFyZW50KClcbiAgICAgICAgICAgICAgICAuZmluZCgnLmZvcm0tY2hpbGQtYm9keScpXG4gICAgICAgICAgICAgICAgLmxhc3QoKVxuICAgICAgICAgICAgICAgIC5maW5kKCcuc2VsZWN0MicpXG4gICAgICAgICAgICAgICAgLnNlbGVjdDIoe1xuICAgICAgICAgICAgICAgIHBsYWNlaG9sZGVyOiAnU2VsZWN0IGFuIG9wdGlvbicsXG4gICAgICAgICAgICAgICAgYWxsb3dDbGVhcjogdHJ1ZSxcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2NoaWxkX2NvdW50JywgY291bnQpO1xuICAgICAgICBkeW5hbWljRmllbGQuYWlkVHlwZVZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgZHluYW1pY0ZpZWxkLnNlY3RvclZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICB9O1xuICAgIC8vIGFkZHMgcGFyZW50IGNvbGxlY3Rpb25cbiAgICBGb3JtQnVpbGRlci5wcm90b3R5cGUuYWRkUGFyZW50Rm9ybSA9IGZ1bmN0aW9uIChldikge1xuICAgICAgICBldi5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICB2YXIgdGFyZ2V0ID0gZXYudGFyZ2V0O1xuICAgICAgICB2YXIgY29udGFpbmVyID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignZm9ybV90eXBlJylcbiAgICAgICAgICAgID8gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKFwiLnBhcmVudC1jb2xsZWN0aW9uW2Zvcm1fdHlwZSA9J1wiLmNvbmNhdCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdmb3JtX3R5cGUnKSwgXCInXVwiKSlcbiAgICAgICAgICAgIDogKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcucGFyZW50LWNvbGxlY3Rpb24nKTtcbiAgICAgICAgdmFyIGNvdW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cigncGFyZW50X2NvdW50JylcbiAgICAgICAgICAgID8gcGFyc2VJbnQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cigncGFyZW50X2NvdW50JykpICsgMVxuICAgICAgICAgICAgOiAoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucHJldigpLmZpbmQoJy5tdWx0aS1mb3JtJykubGVuZ3RoXG4gICAgICAgICAgICAgICAgPyAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wcmV2KCkuZmluZCgnLm11bHRpLWZvcm0nKS5sZW5ndGhcbiAgICAgICAgICAgICAgICA6ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLnByZXYoKS5maW5kKCcud3JhcHBlZC1jaGlsZC1ib2R5JykubGVuZ3RoKSArIDE7XG4gICAgICAgIHZhciBwcm90byA9IGNvbnRhaW5lci5kYXRhKCdwcm90b3R5cGUnKS5yZXBsYWNlKC9fX1BBUkVOVF9OQU1FX18vZywgY291bnQpO1xuICAgICAgICBwcm90byA9IHByb3RvLnJlcGxhY2UoL19fTkFNRV9fL2csIDApO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wcmV2KCkuYXBwZW5kKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShwcm90bykpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wcmV2KCkuZmluZCgnLm11bHRpLWZvcm0nKS5sYXN0KCkuZmluZCgnLnNlbGVjdDInKS5zZWxlY3QyKHtcbiAgICAgICAgICAgIHBsYWNlaG9sZGVyOiAnU2VsZWN0IGFuIG9wdGlvbicsXG4gICAgICAgICAgICBhbGxvd0NsZWFyOiB0cnVlLFxuICAgICAgICB9KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldClcbiAgICAgICAgICAgIC5wcmV2KClcbiAgICAgICAgICAgIC5maW5kKCcubXVsdGktZm9ybScpXG4gICAgICAgICAgICAubGFzdCgpXG4gICAgICAgICAgICAuZmluZCgnLmFkZF90b19jb2xsZWN0aW9uJylcbiAgICAgICAgICAgIC5hdHRyKCdwYXJlbnRfY291bnQnLCBjb3VudCk7XG4gICAgICAgIHRoaXMuYWRkV3JhcHBlck9uQWRkKHRhcmdldCk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ3BhcmVudF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgZHluYW1pY0ZpZWxkLmh1bWFuaXRhcmlhblNjb3BlSGlkZVZvY2FidWxhcnlVcmkoKTtcbiAgICAgICAgZHluYW1pY0ZpZWxkLmNvdW50cnlCdWRnZXRIaWRlQ29kZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC5zZWN0b3JWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC5yZWNpcGllbnRWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC5wb2xpY3lWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC50YWdWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC50cmFuc2FjdGlvbkFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIGR5bmFtaWNGaWVsZC5pbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGRVcmkoKTtcbiAgICB9O1xuICAgIC8vIGRlbGV0ZXMgY29sbGVjdGlvblxuICAgIEZvcm1CdWlsZGVyLnByb3RvdHlwZS5kZWxldGVGb3JtID0gZnVuY3Rpb24gKGV2KSB7XG4gICAgICAgIGV2LnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIHZhciB0YXJnZXQgPSBldi50YXJnZXQ7XG4gICAgICAgIHZhciBjb2xsZWN0aW9uTGVuZ3RoID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcubXVsdGktZm9ybScpLmxlbmd0aFxuICAgICAgICAgICAgPyAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5jbG9zZXN0KCcuc3ViZWxlbWVudCcpLmZpbmQoJy5mb3JtLWNoaWxkLWJvZHknKS5sZW5ndGhcbiAgICAgICAgICAgIDogKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuZm9ybS1jaGlsZC1ib2R5JykubGVuZ3RoO1xuICAgICAgICB2YXIgY291bnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5hZGRfdG9fY29sbGVjdGlvbicpLmF0dHIoJ2NoaWxkX2NvdW50JylcbiAgICAgICAgICAgID8gcGFyc2VJbnQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX2NvbGxlY3Rpb24nKS5hdHRyKCdjaGlsZF9jb3VudCcpKSArIDFcbiAgICAgICAgICAgIDogY29sbGVjdGlvbkxlbmd0aDtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX2NvbGxlY3Rpb24nKS5hdHRyKCdjaGlsZF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgaWYgKGNvbGxlY3Rpb25MZW5ndGggPiAxKSB7XG4gICAgICAgICAgICB2YXIgdGcgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5jbG9zZXN0KCcuZm9ybS1jaGlsZC1ib2R5Jyk7XG4gICAgICAgICAgICB0Zy5uZXh0KCcuZXJyb3InKS5yZW1vdmUoKTtcbiAgICAgICAgICAgIHRnLnJlbW92ZSgpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICAvLyBkZWxldGVzIHBhcmVudCBjb2xsZWN0aW9uXG4gICAgRm9ybUJ1aWxkZXIucHJvdG90eXBlLmRlbGV0ZVBhcmVudEZvcm0gPSBmdW5jdGlvbiAoZXYpIHtcbiAgICAgICAgZXYucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgdmFyIHRhcmdldCA9IGV2LnRhcmdldDtcbiAgICAgICAgdmFyIGNvbGxlY3Rpb25MZW5ndGggPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5zdWJlbGVtZW50JykubGVuZ3RoO1xuICAgICAgICB2YXIgY291bnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5hZGRfdG9fcGFyZW50JykuYXR0cignY2hpbGRfY291bnQnKVxuICAgICAgICAgICAgPyBwYXJzZUludCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5hZGRfdG9fcGFyZW50JykuYXR0cignY2hpbGRfY291bnQnKSkgKyAxXG4gICAgICAgICAgICA6IGNvbGxlY3Rpb25MZW5ndGg7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmFkZF90b19wYXJlbnQnKS5hdHRyKCdjaGlsZF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX3BhcmVudCcpLmF0dHIoJ3BhcmVudF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgaWYgKGNvbGxlY3Rpb25MZW5ndGggPiAyKSB7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wYXJlbnQoKS5yZW1vdmUoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgLy9hZGQgd3JhcHBlciBkaXYgYXJvdW5kIHRoZSBhdHRyaWJ1dGVzXG4gICAgRm9ybUJ1aWxkZXIucHJvdG90eXBlLmFkZFdyYXBwZXIgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLm11bHRpLWZvcm0nKS5lYWNoKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKVxuICAgICAgICAgICAgICAgIC5maW5kKCcuYXR0cmlidXRlJylcbiAgICAgICAgICAgICAgICAud3JhcEFsbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJzxkaXYgY2xhc3M9XCJmb3JtLWZpZWxkLWdyb3VwIGZsZXggZmxleC13cmFwIHJvdW5kZWQtYnItbGcgYm9yZGVyLXkgYm9yZGVyLXIgYm9yZGVyLXNwcmluZy01MCBhdHRyaWJ1dGUtd3JhcHBlciBtYi00XCI+PC9kaXY+JykpO1xuICAgICAgICB9KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuc3ViZWxlbWVudCcpXG4gICAgICAgICAgICAuZmluZCgnLndyYXBwZWQtY2hpbGQtYm9keScpXG4gICAgICAgICAgICAuZWFjaChmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcbiAgICAgICAgICAgICAgICAuZmluZCgnLnN1Yi1hdHRyaWJ1dGUnKVxuICAgICAgICAgICAgICAgIC53cmFwQWxsKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnPGRpdiBjbGFzcz1cImZvcm0tZmllbGQtZ3JvdXAgZmxleCBmbGV4LXdyYXAgcm91bmRlZC1ici1sZyBib3JkZXIteSBib3JkZXItciBib3JkZXItc3ByaW5nLTUwIHN1Yi1hdHRyaWJ1dGUtd3JhcHBlciBtYi00XCI+PC9kaXY+JykpO1xuICAgICAgICB9KTtcbiAgICAgICAgdmFyIGZvcm1GaWVsZCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnZm9ybT4uZm9ybS1maWVsZCcpO1xuICAgICAgICBpZiAoZm9ybUZpZWxkLmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIGZvcm1GaWVsZC53cmFwQWxsKCc8ZGl2IGNsYXNzPVwiZm9ybS1maWVsZC1ncm91cC1vdXRlciBncmlkIHhsOmdyaWQtY29scy0yIG1iLTYgLW14LTMgZ2FwLXktNlwiPjwvZGl2PicpO1xuICAgICAgICB9XG4gICAgfTtcbiAgICBGb3JtQnVpbGRlci5wcm90b3R5cGUuYWRkV3JhcHBlck9uQWRkID0gZnVuY3Rpb24gKHRhcmdldCkge1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KVxuICAgICAgICAgICAgLnByZXYoKVxuICAgICAgICAgICAgLmZpbmQoJy5tdWx0aS1mb3JtJylcbiAgICAgICAgICAgIC5sYXN0KClcbiAgICAgICAgICAgIC5maW5kKCcuYXR0cmlidXRlJylcbiAgICAgICAgICAgIC53cmFwQWxsKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnPGRpdiBjbGFzcz1cImZvcm0tZmllbGQtZ3JvdXAgZ3JpZCB4bDpncmlkLWNvbHMtMiByb3VuZGVkLWJyLWxnIGJvcmRlci15IGJvcmRlci1yIGJvcmRlci1zcHJpbmctNTAgYXR0cmlidXRlLXdyYXBwZXIgbWItNFwiPjwvZGl2PicpKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldClcbiAgICAgICAgICAgIC5wcmV2KClcbiAgICAgICAgICAgIC5maW5kKCcubXVsdGktZm9ybScpXG4gICAgICAgICAgICAubGFzdCgpXG4gICAgICAgICAgICAuZmluZCgnLnN1YmVsZW1lbnQnKVxuICAgICAgICAgICAgLmZpbmQoJy53cmFwcGVkLWNoaWxkLWJvZHknKVxuICAgICAgICAgICAgLmVhY2goZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpXG4gICAgICAgICAgICAgICAgLmZpbmQoJy5zdWItYXR0cmlidXRlJylcbiAgICAgICAgICAgICAgICAud3JhcEFsbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJzxkaXYgY2xhc3M9XCJmb3JtLWZpZWxkLWdyb3VwIGZsZXggZmxleC13cmFwIHJvdW5kZWQtYnItbGcgYm9yZGVyLXkgYm9yZGVyLXIgYm9yZGVyLXNwcmluZy01MCBzdWItYXR0cmlidXRlLXdyYXBwZXIgbWItNFwiPjwvZGl2PicpKTtcbiAgICAgICAgfSk7XG4gICAgfTtcbiAgICBGb3JtQnVpbGRlci5wcm90b3R5cGUudGV4dEFyZWFIZWlnaHQgPSBmdW5jdGlvbiAoZXYpIHtcbiAgICAgICAgdmFyIHRhcmdldCA9IGV2LnRhcmdldDtcbiAgICAgICAgdmFyIGhlaWdodCA9IHRhcmdldC5zY3JvbGxIZWlnaHQ7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmNzcygnaGVpZ2h0JywgaGVpZ2h0KTtcbiAgICB9O1xuICAgIEZvcm1CdWlsZGVyLnByb3RvdHlwZS5hZGRUb0NvbGxlY3Rpb24gPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsICcuYWRkX3RvX2NvbGxlY3Rpb24nLCBmdW5jdGlvbiAoZXZlbnQpIHtcbiAgICAgICAgICAgIF90aGlzLmFkZEZvcm0oZXZlbnQpO1xuICAgICAgICB9KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX3BhcmVudCcpLm9uKCdjbGljaycsIGZ1bmN0aW9uIChldmVudCkge1xuICAgICAgICAgICAgX3RoaXMuYWRkUGFyZW50Rm9ybShldmVudCk7XG4gICAgICAgIH0pO1xuICAgIH07XG4gICAgRm9ybUJ1aWxkZXIucHJvdG90eXBlLmRlbGV0ZUNvbGxlY3Rpb24gPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG4gICAgICAgIHZhciBkZWxldGVDb25maXJtYXRpb24gPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5kZWxldGUtY29uZmlybWF0aW9uJyksIGNhbmNlbFBvcHVwID0gJy5jYW5jZWwtcG9wdXAnLCBkZWxldGVDb25maXJtID0gJy5kZWxldGUtY29uZmlybSc7XG4gICAgICAgIHZhciBkZWxldGVJbmRleCA9IHt9LCBjaGlsZE9yUGFyZW50ID0gJyc7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsICcuZGVsZXRlJywgZnVuY3Rpb24gKGV2ZW50KSB7XG4gICAgICAgICAgICBkZWxldGVDb25maXJtYXRpb24uZmFkZUluKCk7XG4gICAgICAgICAgICBkZWxldGVJbmRleCA9IGV2ZW50O1xuICAgICAgICAgICAgY2hpbGRPclBhcmVudCA9ICdjaGlsZCc7XG4gICAgICAgIH0pO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCBjYW5jZWxQb3B1cCwgZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgZGVsZXRlQ29uZmlybWF0aW9uLmZhZGVPdXQoKTtcbiAgICAgICAgICAgIGRlbGV0ZUluZGV4ID0ge307XG4gICAgICAgICAgICBjaGlsZE9yUGFyZW50ID0gJyc7XG4gICAgICAgIH0pO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCBkZWxldGVDb25maXJtLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICBpZiAoY2hpbGRPclBhcmVudCA9PT0gJ2NoaWxkJykge1xuICAgICAgICAgICAgICAgIF90aGlzLmRlbGV0ZUZvcm0oZGVsZXRlSW5kZXgpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZWxzZSBpZiAoY2hpbGRPclBhcmVudCA9PT0gJ3BhcmVudCcpIHtcbiAgICAgICAgICAgICAgICBfdGhpcy5kZWxldGVQYXJlbnRGb3JtKGRlbGV0ZUluZGV4KTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGRlbGV0ZUNvbmZpcm1hdGlvbi5mYWRlT3V0KCk7XG4gICAgICAgICAgICBkZWxldGVJbmRleCA9IHt9O1xuICAgICAgICAgICAgY2hpbGRPclBhcmVudCA9ICcnO1xuICAgICAgICB9KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgJy5kZWxldGUtcGFyZW50JywgZnVuY3Rpb24gKGV2ZW50KSB7XG4gICAgICAgICAgICBkZWxldGVDb25maXJtYXRpb24uZmFkZUluKCk7XG4gICAgICAgICAgICBkZWxldGVJbmRleCA9IGV2ZW50O1xuICAgICAgICAgICAgY2hpbGRPclBhcmVudCA9ICdwYXJlbnQnO1xuICAgICAgICB9KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuc2VsZWN0MicpLnNlbGVjdDIoe1xuICAgICAgICAgICAgcGxhY2Vob2xkZXI6ICdTZWxlY3QgYW4gb3B0aW9uJyxcbiAgICAgICAgICAgIGFsbG93Q2xlYXI6IHRydWUsXG4gICAgICAgIH0pO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2hhbmdlJywgJ2lucHV0W2lkKj1cIltkb2N1bWVudF1cIl0nLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICB2YXIgX2EsIF9iLCBfYztcbiAgICAgICAgICAgIHZhciBlbmRwb2ludCA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmVuZHBvaW50JykuYXR0cignZW5kcG9pbnQnKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJyc7XG4gICAgICAgICAgICB2YXIgZmlsZV9uYW1lID0gKChfYiA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS52YWwoKSkgIT09IG51bGwgJiYgX2IgIT09IHZvaWQgMCA/IF9iIDogJycpLnRvU3RyaW5nKCk7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgIC5maW5kKCdpbnB1dFtpZCo9XCJbdXJsXVwiXScpXG4gICAgICAgICAgICAgICAgLnZhbChcIlwiLmNvbmNhdChlbmRwb2ludCwgXCIvXCIpLmNvbmNhdCgoX2MgPSBmaWxlX25hbWUgPT09IG51bGwgfHwgZmlsZV9uYW1lID09PSB2b2lkIDAgPyB2b2lkIDAgOiBmaWxlX25hbWUuc3BsaXQoJ1xcXFwnKS5wb3AoKSkgPT09IG51bGwgfHwgX2MgPT09IHZvaWQgMCA/IHZvaWQgMCA6IF9jLnJlcGxhY2UoJyAnLCAnXycpKSk7XG4gICAgICAgIH0pO1xuICAgIH07XG4gICAgcmV0dXJuIEZvcm1CdWlsZGVyO1xufSgpKTtcbigwLCBqcXVlcnlfMS5kZWZhdWx0KShmdW5jdGlvbiAoKSB7XG4gICAgdmFyIGZvcm1CdWlsZGVyID0gbmV3IEZvcm1CdWlsZGVyKCk7XG4gICAgZm9ybUJ1aWxkZXIuYWRkV3JhcHBlcigpO1xuICAgIGR5bmFtaWNGaWVsZC5oaWRlU2hvd0Zvcm1GaWVsZHMoKTtcbiAgICBkeW5hbWljRmllbGQudXBkYXRlQWN0aXZpdHlJZGVudGlmaWVyKCk7XG4gICAgZm9ybUJ1aWxkZXIuYWRkVG9Db2xsZWN0aW9uKCk7XG4gICAgZm9ybUJ1aWxkZXIuZGVsZXRlQ29sbGVjdGlvbigpO1xuICAgIC8qKlxuICAgICAqIFRleHQgYXJlYSBoZWlnaHQgb24gdHlwaW5nXG4gICAgICovXG4gICAgdmFyIHRleHRBcmVhVGFyZ2V0ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCd0ZXh0YXJlYS5mb3JtX19pbnB1dCcpO1xuICAgIGlmICh0ZXh0QXJlYVRhcmdldC5sZW5ndGggPiAwKSB7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdpbnB1dCcsICd0ZXh0YXJlYS5mb3JtX19pbnB1dCcsIGZ1bmN0aW9uIChldmVudCkge1xuICAgICAgICAgICAgZm9ybUJ1aWxkZXIudGV4dEFyZWFIZWlnaHQoZXZlbnQpO1xuICAgICAgICB9KTtcbiAgICB9XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ3NlbGVjdDI6b3BlbicsICcuc2VsZWN0MicsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIHNlbGVjdF9zZWFyY2ggPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcuc2VsZWN0Mi1zZWFyY2hfX2ZpZWxkJyk7XG4gICAgICAgIGlmIChzZWxlY3Rfc2VhcmNoKSB7XG4gICAgICAgICAgICBzZWxlY3Rfc2VhcmNoLmZvY3VzKCk7XG4gICAgICAgIH1cbiAgICB9KTtcbiAgICAvKipcbiAgICAgKiBjaGVja3MgcmVnaXN0cmF0aW9uIGFnZW5jeSwgY291bnRyeSBhbmQgcmVnaXN0cmF0aW9uIG51bWJlciB0byBkZWR1Y2UgaWRlbnRpZmllclxuICAgICAqL1xuICAgIHVwZGF0ZVJlZ2lzdHJhdGlvbkFnZW5jeSgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbml6YXRpb25fY291bnRyeScpKTtcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbmlzYXRpb25faWRlbnRpZmllcicpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJyk7XG4gICAgZnVuY3Rpb24gdXBkYXRlUmVnaXN0cmF0aW9uQWdlbmN5KGNvdW50cnkpIHtcbiAgICAgICAgaWYgKGNvdW50cnkudmFsKCkpIHtcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuYWpheCh7IHVybDogJy9vcmdhbmlzYXRpb24vYWdlbmN5LycgKyBjb3VudHJ5LnZhbCgpIH0pLnRoZW4oZnVuY3Rpb24gKHJlc3BvbnNlKSB7XG4gICAgICAgICAgICAgICAgdmFyIF9hO1xuICAgICAgICAgICAgICAgIHZhciBjdXJyZW50X3ZhbCA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI29yZ2FuaXphdGlvbl9yZWdpc3RyYXRpb25fYWdlbmN5JykudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcnO1xuICAgICAgICAgICAgICAgIHZhciB2YWwgPSBmYWxzZTtcbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScpLmVtcHR5KCk7XG4gICAgICAgICAgICAgICAgZm9yICh2YXIgZGF0YSBpbiByZXNwb25zZS5kYXRhKSB7XG4gICAgICAgICAgICAgICAgICAgIGlmIChkYXRhID09PSBjdXJyZW50X3ZhbCkge1xuICAgICAgICAgICAgICAgICAgICAgICAgdmFsID0gdHJ1ZTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScpXG4gICAgICAgICAgICAgICAgICAgICAgICAuYXBwZW5kKG5ldyBPcHRpb24ocmVzcG9uc2UuZGF0YVtkYXRhXSwgZGF0YSwgdHJ1ZSwgdHJ1ZSkpXG4gICAgICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScpXG4gICAgICAgICAgICAgICAgICAgIC52YWwodmFsID8gY3VycmVudF92YWwgOiAnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ3NlbGVjdDI6c2VsZWN0JywgJyNvcmdhbml6YXRpb25fY291bnRyeScsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdXBkYXRlUmVnaXN0cmF0aW9uQWdlbmN5KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKSk7XG4gICAgfSk7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ3NlbGVjdDI6c2VsZWN0JywgJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIGlkZW50aWZpZXIgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykudmFsKCkgKyAnLScgKyAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNyZWdpc3RyYXRpb25fbnVtYmVyJykudmFsKCk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI29yZ2FuaXNhdGlvbl9pZGVudGlmaWVyJykudmFsKGlkZW50aWZpZXIpO1xuICAgIH0pO1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdzZWxlY3QyOmNsZWFyJywgJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIGlkZW50aWZpZXIgPSAnLScgKyAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNyZWdpc3RyYXRpb25fbnVtYmVyJykudmFsKCk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI29yZ2FuaXNhdGlvbl9pZGVudGlmaWVyJykudmFsKGlkZW50aWZpZXIpO1xuICAgIH0pO1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdrZXl1cCcsICcjcmVnaXN0cmF0aW9uX251bWJlcicsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIGlkZW50aWZpZXIgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScpLnZhbCgpICsgJy0nICsgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpLnZhbCgpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbmlzYXRpb25faWRlbnRpZmllcicpLnZhbChpZGVudGlmaWVyKTtcbiAgICB9KTtcbn0pO1xuIl0sIm5hbWVzIjpbIl9faW1wb3J0RGVmYXVsdCIsIm1vZCIsIl9fZXNNb2R1bGUiLCJPYmplY3QiLCJkZWZpbmVQcm9wZXJ0eSIsImV4cG9ydHMiLCJ2YWx1ZSIsIkR5bmFtaWNGaWVsZCIsImpxdWVyeV8xIiwicmVxdWlyZSIsInByb3RvdHlwZSIsImhpZGVTaG93Rm9ybUZpZWxkcyIsImh1bWFuaXRhcmlhblNjb3BlSGlkZVZvY2FidWxhcnlVcmkiLCJjb3VudHJ5QnVkZ2V0SGlkZUNvZGVGaWVsZCIsImFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkIiwic2VjdG9yVm9jYWJ1bGFyeUhpZGVGaWVsZCIsInBvbGljeVZvY2FidWxhcnlIaWRlRmllbGQiLCJyZWNpcGllbnRWb2NhYnVsYXJ5SGlkZUZpZWxkIiwidGFnVm9jYWJ1bGFyeUhpZGVGaWVsZCIsInRyYW5zYWN0aW9uQWlkVHlwZVZvY2FidWxhcnlIaWRlRmllbGQiLCJpbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGRVcmkiLCJfdGhpcyIsImh1bWFuaXRhcmlhblNjb3BlVm9jYWJ1bGFyeSIsImxlbmd0aCIsImVhY2giLCJpbmRleCIsInNjb3BlIiwiX2EiLCJ2YWwiLCJoaWRlSHVtYW5pdGFyaWFuU2NvcGVGaWVsZCIsInRvU3RyaW5nIiwib24iLCJlIiwicGFyYW1zIiwiZGF0YSIsImlkIiwidGFyZ2V0IiwiY2xvc2VzdCIsImZpbmQiLCJzaG93IiwicmVtb3ZlQXR0ciIsInRyaWdnZXIiLCJoaWRlIiwiYXR0ciIsInJlZmVyZW5jZVZvY2FidWxhcnkiLCJpbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGQiLCJyZWZlcmVuY2VVcmkiLCJjb3VudHJ5QnVkZ2V0Vm9jYWJ1bGFyeSIsImhpZGVDb3VudHJ5QnVkZ2V0RmllbGQiLCJjb3VudHJ5QnVkZ2V0Q29kZUlucHV0IiwiY291bnRyeUJ1ZGdldENvZGVTZWxlY3QiLCJhaWR0eXBlX3ZvY2FidWxhcnkiLCJpdGVtIiwiaGlkZUFpZFR5cGVTZWxlY3RGaWVsZCIsImhpZGVUcmFuc2FjdGlvbkFpZFR5cGVTZWxlY3RGaWVsZCIsImRlZmF1bHRfYWlkX3R5cGUiLCJlYXJtYXJraW5nX2NhdGVnb3J5IiwiZWFybWFya2luZ19tb2RhbGl0eSIsImNhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllcyIsImNhc2UxIiwiY2FzZTIiLCJjYXNlMyIsImNhc2U0IiwiYWlkX3R5cGUiLCJwb2xpY3ltYWtlcl92b2NhYnVsYXJ5IiwicG9saWN5X21hcmtlciIsImhpZGVQb2xpY3lNYWtlckZpZWxkIiwiY2FzZTFfc2hvdyIsImNhc2UyX3Nob3ciLCJzZWN0b3Jfdm9jYWJ1bGFyeSIsInNlY3RvciIsImhpZGVTZWN0b3JGaWVsZCIsImNhc2U3X3Nob3ciLCJjYXNlOF9zaG93IiwiY2FzZTk4Xzk5X3Nob3ciLCJkZWZhdWx0X3Nob3ciLCJjYXNlNyIsImNhc2U4IiwiY2FzZTk4Xzk5IiwiZGVmYXVsdF9oaWRlIiwicmVnaW9uX3ZvY2FidWxhcnkiLCJyZWdpb25fdm9jYWIiLCJoaWRlUmVjaXBpZW50UmVnaW9uRmllbGQiLCJjYXNlOTlfc2hvdyIsImNhc2U5OSIsImNvbnNvbGUiLCJsb2ciLCJ1cGRhdGVBY3Rpdml0eUlkZW50aWZpZXIiLCJhY3Rpdml0eV9pZGVudGlmaWVyIiwiY29uY2F0IiwidGFnX3ZvY2FidWxhcnkiLCJ0YWciLCJoaWRlVGFnRmllbGQiLCJjYXNlM19zaG93IiwiRHluYW1pY0ZpZWxkXzEiLCJkeW5hbWljRmllbGQiLCJGb3JtQnVpbGRlciIsImFkZEZvcm0iLCJldiIsInByZXZlbnREZWZhdWx0IiwiY29udGFpbmVyIiwiY291bnQiLCJwYXJzZUludCIsInBhcmVudCIsInBhcmVudF9jb3VudCIsInByZXZBbGwiLCJ3cmFwcGVyX3BhcmVudF9jb3VudCIsInByb3RvIiwicmVwbGFjZSIsInByZXYiLCJhcHBlbmQiLCJjaGlsZHJlbiIsImxhc3QiLCJzZWxlY3QyIiwicGxhY2Vob2xkZXIiLCJhbGxvd0NsZWFyIiwid3JhcEFsbCIsImFkZFBhcmVudEZvcm0iLCJhZGRXcmFwcGVyT25BZGQiLCJkZWxldGVGb3JtIiwiY29sbGVjdGlvbkxlbmd0aCIsInRnIiwibmV4dCIsInJlbW92ZSIsImRlbGV0ZVBhcmVudEZvcm0iLCJhZGRXcmFwcGVyIiwiZm9ybUZpZWxkIiwidGV4dEFyZWFIZWlnaHQiLCJoZWlnaHQiLCJzY3JvbGxIZWlnaHQiLCJjc3MiLCJhZGRUb0NvbGxlY3Rpb24iLCJldmVudCIsImRlbGV0ZUNvbGxlY3Rpb24iLCJkZWxldGVDb25maXJtYXRpb24iLCJjYW5jZWxQb3B1cCIsImRlbGV0ZUNvbmZpcm0iLCJkZWxldGVJbmRleCIsImNoaWxkT3JQYXJlbnQiLCJmYWRlSW4iLCJmYWRlT3V0IiwiX2IiLCJfYyIsImVuZHBvaW50IiwiZmlsZV9uYW1lIiwic3BsaXQiLCJwb3AiLCJmb3JtQnVpbGRlciIsInRleHRBcmVhVGFyZ2V0Iiwic2VsZWN0X3NlYXJjaCIsImRvY3VtZW50IiwicXVlcnlTZWxlY3RvciIsImZvY3VzIiwidXBkYXRlUmVnaXN0cmF0aW9uQWdlbmN5IiwiY291bnRyeSIsImFqYXgiLCJ1cmwiLCJ0aGVuIiwicmVzcG9uc2UiLCJjdXJyZW50X3ZhbCIsImVtcHR5IiwiT3B0aW9uIiwiaWRlbnRpZmllciJdLCJzb3VyY2VSb290IjoiIn0=
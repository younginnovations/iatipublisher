"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["/js/formbuilder"],{

/***/ "./resources/assets/js/scripts/DynamicField.ts":
/*!*****************************************************!*\
  !*** ./resources/assets/js/scripts/DynamicField.ts ***!
  \*****************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {



function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
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
var DynamicField = /*#__PURE__*/function () {
  function DynamicField() {
    _classCallCheck(this, DynamicField);
  }
  _createClass(DynamicField, [{
    key: "hideShowFormFields",
    value:
    /**
     * Hide and Show different form fields based on vocabulary and other types
     */
    function hideShowFormFields() {
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
    }
    /**
     * Humanitarian Scope Form Page
     *
     * @Logic hide vocabulary-uri field based on '@vocabulary' field value
     */
  }, {
    key: "humanitarianScopeHideVocabularyUri",
    value: function humanitarianScopeHideVocabularyUri() {
      var _this = this;
      var humanitarianScopeVocabulary = (0, jquery_1["default"])('select[id^="humanitarian_scope"][id*="[vocabulary]"]');
      if (humanitarianScopeVocabulary.length > 0) {
        // hide fields on page load
        jquery_1["default"].each(humanitarianScopeVocabulary, function (index, scope) {
          var _a;
          var val = (_a = (0, jquery_1["default"])(scope).val()) !== null && _a !== void 0 ? _a : '';
          _this.hideHumanitarianScopeField((0, jquery_1["default"])(scope), val.toString());
        });
        // hide/show fields on value change
        humanitarianScopeVocabulary.on('select2:select', function (e) {
          var val = e.params.data.id;
          var index = e.target;
          _this.hideHumanitarianScopeField((0, jquery_1["default"])(index), val);
        });
        // hide/show fields on value clear
        humanitarianScopeVocabulary.on('select2:clear', function (e) {
          var index = e.target;
          _this.hideHumanitarianScopeField((0, jquery_1["default"])(index), '');
        });
      }
    }
    // hide country budget based on vocabulary
  }, {
    key: "hideHumanitarianScopeField",
    value: function hideHumanitarianScopeField(index, value) {
      var humanitarianScopeHideVocabularyUri = 'input[id^="humanitarian_scope"][id*="[vocabulary_uri]"]';
      if (value === '99') {
        index.closest('.form-field-group').find(humanitarianScopeHideVocabularyUri).show().removeAttr('disabled').closest('.form-field').show();
      } else {
        index.closest('.form-field-group').find(humanitarianScopeHideVocabularyUri).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
      }
    }
    /**
     * Humanitarian Scope Form Page
     *
     * @Logic hide vocabulary-uri field based on '@vocabulary' field value
     */
  }, {
    key: "indicatorReferenceHideFieldUri",
    value: function indicatorReferenceHideFieldUri() {
      var _this2 = this;
      var referenceVocabulary = (0, jquery_1["default"])('select[id^="reference"][id*="[vocabulary]"]');
      if (referenceVocabulary.length > 0) {
        // hide fields on page load
        jquery_1["default"].each(referenceVocabulary, function (index, scope) {
          var _a;
          var val = (_a = (0, jquery_1["default"])(scope).val()) !== null && _a !== void 0 ? _a : '';
          _this2.indicatorReferenceHideField((0, jquery_1["default"])(scope), val.toString());
        });
        // hide/show fields on value change
        referenceVocabulary.on('select2:select', function (e) {
          var val = e.params.data.id;
          var index = e.target;
          _this2.indicatorReferenceHideField((0, jquery_1["default"])(index), val);
        });
        // hide/show fields on value clear
        referenceVocabulary.on('select2:clear', function (e) {
          var index = e.target;
          _this2.indicatorReferenceHideField((0, jquery_1["default"])(index), '');
        });
      }
    }
    // hide country budget based on vocabulary
  }, {
    key: "indicatorReferenceHideField",
    value: function indicatorReferenceHideField(index, value) {
      var referenceUri = 'input[id^="reference"][id*="[indicator_uri]"]';
      if (value === '99') {
        index.closest('.form-field-group').find(referenceUri).show().removeAttr('disabled').closest('.form-field').show();
      } else {
        index.closest('.form-field-group').find(referenceUri).val('').trigger('change').hide().attr('disabled', 'disabled').closest('.form-field').hide();
      }
    }
    /**
     * Country Budget Form Page
     *
     * @Logic show/hide 'code' field based on '@vocabulary' field value
     */
  }, {
    key: "countryBudgetHideCodeField",
    value: function countryBudgetHideCodeField() {
      var _this3 = this;
      var _a;
      var countryBudgetVocabulary = (0, jquery_1["default"])('select#country_budget_vocabulary');
      if (countryBudgetVocabulary.length > 0) {
        // hide/show on page load
        var val = (_a = countryBudgetVocabulary.val()) !== null && _a !== void 0 ? _a : '1';
        this.hideCountryBudgetField(val.toString());
        // hide/show on value change
        countryBudgetVocabulary.on('select2:select', function (e) {
          var val = e.params.data.id;
          _this3.hideCountryBudgetField(val);
        });
        //hide/show based on value cleared
        countryBudgetVocabulary.on('select2:clear', function () {
          _this3.hideCountryBudgetField('');
        });
      }
    }
    /**
     * Hide Country Budget Fields
     */
  }, {
    key: "hideCountryBudgetField",
    value: function hideCountryBudgetField(value) {
      var countryBudgetCodeInput = 'input[id^="budget_item"][id*="[code_text]"]',
        countryBudgetCodeSelect = 'select[id^="budget_item"][id*="[code]"]';
      if (value === '1') {
        (0, jquery_1["default"])(countryBudgetCodeSelect).val('').trigger('change').attr('disabled', 'disabled').closest('.form-field').hide();
        (0, jquery_1["default"])(countryBudgetCodeInput).removeAttr('disabled').closest('.form-field').show();
      } else {
        (0, jquery_1["default"])(countryBudgetCodeSelect).removeAttr('disabled').closest('.form-field').show();
        (0, jquery_1["default"])(countryBudgetCodeInput).val('').trigger('change').closest('.form-field').hide();
      }
    }
    /**
     * AidType Form Page
     *
     * @Logic hide vocabulary-uri and codes field based on '@vocabulary' field value
     */
  }, {
    key: "aidTypeVocabularyHideField",
    value: function aidTypeVocabularyHideField() {
      var _this4 = this;
      var aidtype_vocabulary = (0, jquery_1["default"])('select[id*="default_aid_type_vocabulary"]');
      if (aidtype_vocabulary.length > 0) {
        jquery_1["default"].each(aidtype_vocabulary, function (index, item) {
          var _a;
          var data = (_a = (0, jquery_1["default"])(item).val()) !== null && _a !== void 0 ? _a : '1';
          _this4.hideAidTypeSelectField((0, jquery_1["default"])(item), data.toString());
        });
        aidtype_vocabulary.on('select2:select', function (e) {
          var data = e.params.data.id;
          var target = e.target;
          _this4.hideAidTypeSelectField((0, jquery_1["default"])(target), data);
        });
        aidtype_vocabulary.on('select2:clear', function (e) {
          var target = e.target;
          _this4.hideAidTypeSelectField((0, jquery_1["default"])(target), '');
        });
      }
    }
    /**
     * AidType Form Page
     *
     * @Logic hide vocabulary-uri and codes field based on '@vocabulary' field value
     */
  }, {
    key: "transactionAidTypeVocabularyHideField",
    value: function transactionAidTypeVocabularyHideField() {
      var _this5 = this;
      var aidtype_vocabulary = (0, jquery_1["default"])('select[id*="aid_type_vocabulary"]');
      if (aidtype_vocabulary.length > 0) {
        jquery_1["default"].each(aidtype_vocabulary, function (index, item) {
          var _a;
          var data = (_a = (0, jquery_1["default"])(item).val()) !== null && _a !== void 0 ? _a : '1';
          _this5.hideTransactionAidTypeSelectField((0, jquery_1["default"])(item), data.toString());
        });
        aidtype_vocabulary.on('select2:select', function (e) {
          var data = e.params.data.id;
          var target = e.target;
          _this5.hideTransactionAidTypeSelectField((0, jquery_1["default"])(target), data);
        });
        aidtype_vocabulary.on('select2:clear', function (e) {
          var target = e.target;
          _this5.hideTransactionAidTypeSelectField((0, jquery_1["default"])(target), '');
        });
      }
    }
    /**
     * Hide Aid Type Select Fields
     */
  }, {
    key: "hideAidTypeSelectField",
    value: function hideAidTypeSelectField(index, value) {
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
    }
    /**
     * Hide Transaction Aid Type Select Fields
     */
  }, {
    key: "hideTransactionAidTypeSelectField",
    value: function hideTransactionAidTypeSelectField(index, value) {
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
    }
    /**
     * Policy Marker Form Page
     *
     * @Logic hide vocabulary-uri and codes field based on '@vocabulary' field value
     */
  }, {
    key: "policyVocabularyHideField",
    value: function policyVocabularyHideField() {
      var _this6 = this;
      var policymaker_vocabulary = (0, jquery_1["default"])('select[id*="policy_marker_vocabulary"]');
      if (policymaker_vocabulary.length > 0) {
        jquery_1["default"].each(policymaker_vocabulary, function (index, policy_marker) {
          var _a;
          var data = (_a = (0, jquery_1["default"])(policy_marker).val()) !== null && _a !== void 0 ? _a : '1';
          _this6.hidePolicyMakerField((0, jquery_1["default"])(policy_marker), data.toString());
        });
        policymaker_vocabulary.on('select2:select', function (e) {
          var data = e.params.data.id;
          var target = e.target;
          _this6.hidePolicyMakerField((0, jquery_1["default"])(target), data);
        });
        policymaker_vocabulary.on('select2:clear', function (e) {
          var target = e.target;
          _this6.hidePolicyMakerField((0, jquery_1["default"])(target), '99');
        });
      }
    }
    /**
     * Hides Policy Marker Form Fields
     */
  }, {
    key: "hidePolicyMakerField",
    value: function hidePolicyMakerField(index, value) {
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
    }
    /**
     * Sector Form Page
     *
     * @Logic hide vocabulary-uri and codes field based on '@vocabulary' field value
     */
  }, {
    key: "sectorVocabularyHideField",
    value: function sectorVocabularyHideField() {
      var _this7 = this;
      var sector_vocabulary = (0, jquery_1["default"])('select[id*="sector_vocabulary"]');
      if (sector_vocabulary.length > 0) {
        jquery_1["default"].each(sector_vocabulary, function (index, sector) {
          var _a;
          var data = (_a = (0, jquery_1["default"])(sector).val()) !== null && _a !== void 0 ? _a : '1';
          _this7.hideSectorField((0, jquery_1["default"])(sector), data.toString());
        });
        sector_vocabulary.on('select2:select', function (e) {
          var data = e.params.data.id;
          var target = e.target;
          _this7.hideSectorField((0, jquery_1["default"])(target), data);
        });
        sector_vocabulary.on('select2:clear', function (e) {
          var target = e.target;
          _this7.hideSectorField((0, jquery_1["default"])(target), '');
        });
      }
    }
    /**
     * Hide Sector Form fields
     */
  }, {
    key: "hideSectorField",
    value: function hideSectorField(index, value) {
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
    }
    /**
     *  Recipient Vocabulary Form Page
     *
     * @Logic hide vocabulary-uri and codes field based on '@vocabulary' field value
     */
  }, {
    key: "recipientVocabularyHideField",
    value: function recipientVocabularyHideField() {
      var _this8 = this;
      var region_vocabulary = (0, jquery_1["default"])('select[id*="region_vocabulary"]');
      if (region_vocabulary.length > 0) {
        jquery_1["default"].each(region_vocabulary, function (index, region_vocab) {
          var _a;
          var data = (_a = (0, jquery_1["default"])(region_vocab).val()) !== null && _a !== void 0 ? _a : '1';
          _this8.hideRecipientRegionField((0, jquery_1["default"])(region_vocab), data.toString());
        });
        region_vocabulary.on('select2:select', function (e) {
          var data = e.params.data.id;
          var target = e.target;
          _this8.hideRecipientRegionField((0, jquery_1["default"])(target), data);
        });
        region_vocabulary.on('select2:clear', function (e) {
          var target = e.target;
          _this8.hideRecipientRegionField((0, jquery_1["default"])(target), '');
        });
      }
    }
    /**
     * Hides Recipient Region Form Fields
     */
  }, {
    key: "hideRecipientRegionField",
    value: function hideRecipientRegionField(index, value) {
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
    }
    /**
     * Updates Activity identifier
     */
  }, {
    key: "updateActivityIdentifier",
    value: function updateActivityIdentifier() {
      var activity_identifier = (0, jquery_1["default"])('#activity_identifier');
      if (activity_identifier.length > 0) {
        activity_identifier.on('keyup', function () {
          (0, jquery_1["default"])('#iati_identifier_text').val((0, jquery_1["default"])('.identifier').attr('activity_identifier') + "-".concat((0, jquery_1["default"])(this).val()));
        });
      }
    }
    /**
     * Tag Form Page
     *
     * @Logic hide vocabulary-uri and codes field based on '@vocabulary' field value
     */
  }, {
    key: "tagVocabularyHideField",
    value: function tagVocabularyHideField() {
      var _this9 = this;
      var tag_vocabulary = (0, jquery_1["default"])('select[id*="tag_vocabulary"]');
      if (tag_vocabulary.length > 0) {
        jquery_1["default"].each(tag_vocabulary, function (index, tag) {
          var _a;
          var data = (_a = (0, jquery_1["default"])(tag).val()) !== null && _a !== void 0 ? _a : '1';
          _this9.hideTagField((0, jquery_1["default"])(tag), data.toString());
        });
        tag_vocabulary.on('select2:select', function (e) {
          var data = e.params.data.id;
          var target = e.target;
          _this9.hideTagField((0, jquery_1["default"])(target), data);
        });
        tag_vocabulary.on('select2:clear', function (e) {
          var target = e.target;
          _this9.hideTagField((0, jquery_1["default"])(target), '');
        });
      }
    }
    /**
     * Hide Tag Form fields
     */
  }, {
    key: "hideTagField",
    value: function hideTagField(index, value) {
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
    }
  }]);
  return DynamicField;
}();
exports.DynamicField = DynamicField;
/*
 *
 * Help Text Open Close Handlers Start
 *
 */
(0, jquery_1["default"])(document).on('click', function (event) {
  if (!(0, jquery_1["default"])(event.target).closest('.help').length) {
    (0, jquery_1["default"])('.help__text').removeAttr('style');
  }
});
(0, jquery_1["default"])(document).on('click', '.help', function (event) {
  event.stopPropagation();
  console.log('Hello');
  (0, jquery_1["default"])('.help__text').removeAttr('style');
  var helpText = (0, jquery_1["default"])(this).find('.help__text');
  if (helpText.length > 0) {
    helpText.css({
      opacity: '1',
      visibility: 'visible'
    });
  }
  if ((0, jquery_1["default"])(event.target).closest('.close-help').length) {
    closeHelpText(helpText);
  }
});
(0, jquery_1["default"])(document).on('keydown', function (event) {
  if (event.key === 'Escape') {
    (0, jquery_1["default"])('.help__text').each(function () {
      closeHelpText((0, jquery_1["default"])(this));
    });
  }
});
/**
 * Closes the help text tooltip by setting its CSS properties to make it invisible and non-interactive.
 * After a delay, it removes the inline styles to reset the element's state.
 *
 * @param helpText - The jQuery object representing the tooltip element to be closed.
 */
function closeHelpText(helpText) {
  helpText.css({
    'pointer-events': 'none',
    opacity: '0',
    visibility: 'invisible'
  });
  setTimeout(function () {
    helpText.removeAttr('style');
  }, 1000);
}
/*
 *
 * Help Text Open Close Handlers End
 *
 */

/***/ }),

/***/ "./resources/assets/js/scripts/formbuilder.ts":
/*!****************************************************!*\
  !*** ./resources/assets/js/scripts/formbuilder.ts ***!
  \****************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {



function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }
function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
var __importDefault = this && this.__importDefault || function (mod) {
  return mod && mod.__esModule ? mod : {
    "default": mod
  };
};
Object.defineProperty(exports, "__esModule", ({
  value: true
}));
var axios_1 = __importDefault(__webpack_require__(/*! axios */ "./node_modules/axios/dist/browser/axios.cjs"));
var jquery_1 = __importDefault(__webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js"));
__webpack_require__(/*! select2 */ "./node_modules/select2/dist/js/select2.js");
var DynamicField_1 = __webpack_require__(/*! ./DynamicField */ "./resources/assets/js/scripts/DynamicField.ts");
var dynamicField = new DynamicField_1.DynamicField();
var FormBuilder = /*#__PURE__*/function () {
  function FormBuilder() {
    _classCallCheck(this, FormBuilder);
  }
  _createClass(FormBuilder, [{
    key: "addForm",
    value:
    // adds new collection of sub-element
    function addForm(ev) {
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
        (0, jquery_1["default"])(this).find('.sub-attribute').wrapAll((0, jquery_1["default"])('<div class="form-field-group flex flex-wrap sub-attribute-wrapper"></div>'));
        (0, jquery_1["default"])(target).prev('.subelement').children('.wrapped-child-body').last().find('.sub-attribute').wrapAll((0, jquery_1["default"])('<div class="form-field-group flex flex-wrap sub-attribute-wrapper mt-6"></div>'));
      } else {
        (0, jquery_1["default"])(target).parent().find('.form-child-body').last().find('.select2').select2({
          placeholder: 'Select an option',
          allowClear: true
        });
      }
      (0, jquery_1["default"])(target).attr('child_count', count);
      dynamicField.aidTypeVocabularyHideField();
      dynamicField.sectorVocabularyHideField();
    }
    // adds parent collection
  }, {
    key: "addParentForm",
    value: function addParentForm(ev) {
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
    }
    // deletes collection
  }, {
    key: "deleteForm",
    value: function deleteForm(ev) {
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
    }
    // deletes parent collection
  }, {
    key: "deleteParentForm",
    value: function deleteParentForm(ev) {
      ev.preventDefault();
      var target = ev.target;
      var collectionLength = (0, jquery_1["default"])('.subelement').length;
      var count = (0, jquery_1["default"])('.add_to_parent').attr('child_count') ? parseInt((0, jquery_1["default"])('.add_to_parent').attr('child_count')) + 1 : collectionLength;
      (0, jquery_1["default"])('.add_to_parent').attr('child_count', count);
      (0, jquery_1["default"])('.add_to_parent').attr('parent_count', count);
      if (collectionLength > 2) {
        (0, jquery_1["default"])(target).parent().remove();
      }
    }
    //add wrapper div around the attributes
  }, {
    key: "addWrapper",
    value: function addWrapper() {
      (0, jquery_1["default"])('.multi-form').each(function () {
        (0, jquery_1["default"])(this).find('.attribute').wrapAll((0, jquery_1["default"])('<div class="form-field-group flex flex-wrap attribute-wrapper mb-4"></div>'));
      });
      (0, jquery_1["default"])('.subelement').find('.wrapped-child-body').each(function () {
        (0, jquery_1["default"])(this).find('.sub-attribute').wrapAll((0, jquery_1["default"])('<div class="form-field-group flex flex-wrap sub-attribute-wrapper mb-4"></div>'));
      });
      var formField = (0, jquery_1["default"])('form>.form-field');
      if (formField.length > 0) {
        formField.wrapAll('<div class="form-field-group-outer grid xl:grid-cols-2 mb-6 -mx-3 gap-y-6"></div>');
      }
    }
  }, {
    key: "addWrapperOnAdd",
    value: function addWrapperOnAdd(target) {
      (0, jquery_1["default"])(target).prev().find('.multi-form').last().find('.attribute').wrapAll((0, jquery_1["default"])('<div class="form-field-group grid xl:grid-cols-2 attribute-wrapper mb-4"></div>'));
      (0, jquery_1["default"])(target).prev().find('.multi-form').last().find('.subelement').find('.wrapped-child-body').each(function () {
        (0, jquery_1["default"])(this).find('.sub-attribute').wrapAll((0, jquery_1["default"])('<div class="form-field-group flex flex-wrap sub-attribute-wrapper mb-4"></div>'));
      });
    }
  }, {
    key: "textAreaHeight",
    value: function textAreaHeight(ev) {
      var target = ev.target;
      var height = target.scrollHeight;
      (0, jquery_1["default"])(target).css('height', height);
    }
  }, {
    key: "addToCollection",
    value: function addToCollection() {
      var _this = this;
      (0, jquery_1["default"])('body').on('click', '.add_to_collection', function (event) {
        if ((0, jquery_1["default"])(event.target).hasClass('add-icon')) {
          event.stopPropagation();
          (0, jquery_1["default"])(event.target).parent('button').trigger('click');
        } else {
          _this.addForm(event);
          _this.handleDeleteParentButtons();
        }
      });
      (0, jquery_1["default"])('.add_to_parent').on('click', function (event) {
        if ((0, jquery_1["default"])(event.target).hasClass('add-icon')) {
          event.stopPropagation();
          (0, jquery_1["default"])(event.target).parent('button').trigger('click');
        } else {
          _this.addParentForm(event);
          _this.handleDeleteParentButtons();
        }
      });
    }
  }, {
    key: "deleteCollection",
    value: function deleteCollection() {
      var _this2 = this;
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
          _this2.deleteForm(deleteIndex);
        } else if (childOrParent === 'parent') {
          _this2.deleteParentForm(deleteIndex);
        }
        deleteConfirmation.fadeOut();
        deleteIndex = {};
        childOrParent = '';
      });
      (0, jquery_1["default"])('body').on('mouseenter', '.delete-parent', function (event) {
        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
        //@ts-ignore
        var deleteButton = (0, jquery_1["default"])(event.target);
        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
        //@ts-ignore
        var multiForm = deleteButton.closest('.multi-form, .wrapped-child-body');
        multiForm.css({
          background: '#FFF8F7',
          outline: '2px solid #F19BA0'
        });
      });
      (0, jquery_1["default"])('body').on('mouseleave', '.delete-parent', function (event) {
        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
        //@ts-ignore
        var deleteButton = (0, jquery_1["default"])(event.target);
        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
        //@ts-ignore
        var multiForm = deleteButton.closest('.multi-form, .wrapped-child-body');
        multiForm.css({
          background: '',
          outline: ''
        });
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
      // update format on change of document link
      (0, jquery_1["default"])('body').on('change', 'input[id*="[url]"]', function () {
        var _this3 = this;
        var _a;
        var filePath = ((_a = (0, jquery_1["default"])(this).val()) !== null && _a !== void 0 ? _a : '').toString();
        var document = (0, jquery_1["default"])(this).closest('.form-field-group').find('input[id*="[document]"]').val();
        var url = "/mimetype?url=".concat(filePath, "&type=url");
        (0, jquery_1["default"])(this).closest('.form-field').find('.text-danger').remove();
        if (filePath !== '') {
          axios_1["default"].get(url).then(function (response) {
            if (response.data.success) {
              var format = response.data.data.mimetype;
              (0, jquery_1["default"])(_this3).closest('.form-field-group').find('select[id*="[format]"]').val(format).trigger('change');
            } else {
              (0, jquery_1["default"])(_this3).closest('.form-field').find('.text-danger').remove();
              (0, jquery_1["default"])(_this3).closest('.form-field').append("<div class='text-danger error'>" + response.data.message + '</div>');
              (0, jquery_1["default"])(_this3).closest('.form-field-group').find('select[id*="[format]"]').val('').trigger('change');
            }
            (0, jquery_1["default"])(_this3).closest('.form-field-group').find('input[id*="[document]"]').val('').trigger('change');
          });
        } else if (!document || document === '') {
          (0, jquery_1["default"])(this).closest('.form-field-group').find('select[id*="[format]"]').val('').trigger('change');
        }
      });
      (0, jquery_1["default"])('body').on('change', 'input[id*="[document]"]', function () {
        var _this4 = this;
        var _a;
        var filePath = ((_a = (0, jquery_1["default"])(this).val()) !== null && _a !== void 0 ? _a : '').toString();
        var url = "/mimetype?url=".concat(filePath, "&&type=document");
        var fileUrl = (0, jquery_1["default"])(this).closest('.form-field-group').find('input[id*="[url]"]').val();
        (0, jquery_1["default"])(this).closest('.form-field').find('.text-danger').remove();
        if (filePath !== '') {
          axios_1["default"].get(url).then(function (response) {
            if (response.data.success) {
              var format = response.data.data.mimetype;
              (0, jquery_1["default"])(_this4).closest('.form-field-group').find('select[id*="[format]"]').val(format).trigger('change');
            } else {
              (0, jquery_1["default"])(_this4).closest('.form-field-group').find('select[id*="[format]"]').val('').trigger('change');
            }
          });
          (0, jquery_1["default"])(this).closest('.form-field-group').find('input[id*="[url]"]').val('').trigger('change');
        } else if (!fileUrl || fileUrl === '') {
          (0, jquery_1["default"])(this).closest('.form-field-group').find('select[id*="[format]"]').val('').trigger('change');
        }
      });
    }
  }, {
    key: "handleDeleteParentButtons",
    value: function handleDeleteParentButtons() {
      var deleteButtons = document.querySelectorAll('.delete-parent-selector');
      var changeDeleteButtonInnerHtml = function changeDeleteButtonInnerHtml(button) {
        var initialText = escapeHtml(button.textContent);
        button.innerHTML = "\n         <svg class=\"text-[1rem] mb-0.5\" viewBox=\"0 0 16 16\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n           <path d=\"M6.66667 12C6.84348 12 7.01305 11.9298 7.13807 11.8047C7.2631 11.6797 7.33333 11.5101 7.33333 11.3333V7.33334C7.33333 7.15653 7.2631 6.98696 7.13807 6.86193C7.01305 6.73691 6.84348 6.66667 6.66667 6.66667C6.48986 6.66667 6.32029 6.73691 6.19526 6.86193C6.07024 6.98696 6 7.15653 6 7.33334V11.3333C6 11.5101 6.07024 11.6797 6.19526 11.8047C6.32029 11.9298 6.48986 12 6.66667 12ZM13.3333 4H10.6667V3.33334C10.6667 2.8029 10.456 2.2942 10.0809 1.91912C9.70581 1.54405 9.1971 1.33334 8.66667 1.33334H7.33333C6.8029 1.33334 6.29419 1.54405 5.91912 1.91912C5.54405 2.2942 5.33333 2.8029 5.33333 3.33334V4H2.66667C2.48986 4 2.32029 4.07024 2.19526 4.19526C2.07024 4.32029 2 4.48986 2 4.66667C2 4.84348 2.07024 5.01305 2.19526 5.13807C2.32029 5.2631 2.48986 5.33334 2.66667 5.33334H3.33333V12.6667C3.33333 13.1971 3.54405 13.7058 3.91912 14.0809C4.29419 14.456 4.8029 14.6667 5.33333 14.6667H10.6667C11.1971 14.6667 11.7058 14.456 12.0809 14.0809C12.456 13.7058 12.6667 13.1971 12.6667 12.6667V5.33334H13.3333C13.5101 5.33334 13.6797 5.2631 13.8047 5.13807C13.9298 5.01305 14 4.84348 14 4.66667C14 4.48986 13.9298 4.32029 13.8047 4.19526C13.6797 4.07024 13.5101 4 13.3333 4ZM6.66667 3.33334C6.66667 3.15652 6.7369 2.98696 6.86193 2.86193C6.98695 2.73691 7.15652 2.66667 7.33333 2.66667H8.66667C8.84348 2.66667 9.01305 2.73691 9.13807 2.86193C9.2631 2.98696 9.33333 3.15652 9.33333 3.33334V4H6.66667V3.33334ZM11.3333 12.6667C11.3333 12.8435 11.2631 13.0131 11.1381 13.1381C11.013 13.2631 10.8435 13.3333 10.6667 13.3333H5.33333C5.15652 13.3333 4.98695 13.2631 4.86193 13.1381C4.7369 13.0131 4.66667 12.8435 4.66667 12.6667V5.33334H11.3333V12.6667ZM9.33333 12C9.51014 12 9.67971 11.9298 9.80474 11.8047C9.92976 11.6797 10 11.5101 10 11.3333V7.33334C10 7.15653 9.92976 6.98696 9.80474 6.86193C9.67971 6.73691 9.51014 6.66667 9.33333 6.66667C9.15652 6.66667 8.98695 6.73691 8.86193 6.86193C8.73691 6.98696 8.66667 7.15653 8.66667 7.33334V11.3333C8.66667 11.5101 8.73691 11.6797 8.86193 11.8047C8.98695 11.9298 9.15652 12 9.33333 12Z\" fill=\"#E34D5B\"/>\n         </svg>\n         ".concat(initialText, "\n      ");
      };
      deleteButtons.forEach(function (button) {
        changeDeleteButtonInnerHtml(button);
      });
    }
  }]);
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
    var endpoint = country.val() ? '/organisation/agency/' + country.val() : '/organisation/agency/';
    jquery_1["default"].ajax({
      url: endpoint
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
  });
  // add class to title of collection when validation error occurs on collection level
  var subelement = document.querySelectorAll('.subelement');
  for (var i = 0; i < subelement.length; i++) {
    var title = subelement[i].querySelector('.control-label');
    var errorContainer = subelement[i].querySelector('.collection_error');
    var childCount = errorContainer === null || errorContainer === void 0 ? void 0 : errorContainer.childElementCount;
    if (childCount && childCount > 0) {
      title === null || title === void 0 ? void 0 : title.classList.add('error-title');
    }
  }
  // Adding cursor not allowed to <select> where elementJsonSchema read_only : true
  var readOnlySelects = document.querySelectorAll('select.cursor-not-allowed');
  for (var _i = 0; _i < readOnlySelects.length; _i++) {
    var select = readOnlySelects[_i];
    var selectElementParentWrapper = select.nextSibling;
    var selectElementParent = selectElementParentWrapper === null || selectElementParentWrapper === void 0 ? void 0 : selectElementParentWrapper.firstChild;
    var selectElement = selectElementParent === null || selectElementParent === void 0 ? void 0 : selectElementParent.firstChild;
    if (selectElement) {
      selectElement.style.cursor = 'not-allowed';
    }
  }
  var deleteButtons = document.querySelectorAll('.delete-parent-selector');
  function changeDeleteButtonInnerHtml(button) {
    var initialText = escapeHtml(button.textContent);
    button.innerHTML = "\n      <svg width=\"16\" height=\"16\" viewBox=\"0 0 16 16\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n        <path d=\"M6.66667 12C6.84348 12 7.01305 11.9298 7.13807 11.8047C7.2631 11.6797 7.33333 11.5101 7.33333 11.3333V7.33334C7.33333 7.15653 7.2631 6.98696 7.13807 6.86193C7.01305 6.73691 6.84348 6.66667 6.66667 6.66667C6.48986 6.66667 6.32029 6.73691 6.19526 6.86193C6.07024 6.98696 6 7.15653 6 7.33334V11.3333C6 11.5101 6.07024 11.6797 6.19526 11.8047C6.32029 11.9298 6.48986 12 6.66667 12ZM13.3333 4H10.6667V3.33334C10.6667 2.8029 10.456 2.2942 10.0809 1.91912C9.70581 1.54405 9.1971 1.33334 8.66667 1.33334H7.33333C6.8029 1.33334 6.29419 1.54405 5.91912 1.91912C5.54405 2.2942 5.33333 2.8029 5.33333 3.33334V4H2.66667C2.48986 4 2.32029 4.07024 2.19526 4.19526C2.07024 4.32029 2 4.48986 2 4.66667C2 4.84348 2.07024 5.01305 2.19526 5.13807C2.32029 5.2631 2.48986 5.33334 2.66667 5.33334H3.33333V12.6667C3.33333 13.1971 3.54405 13.7058 3.91912 14.0809C4.29419 14.456 4.8029 14.6667 5.33333 14.6667H10.6667C11.1971 14.6667 11.7058 14.456 12.0809 14.0809C12.456 13.7058 12.6667 13.1971 12.6667 12.6667V5.33334H13.3333C13.5101 5.33334 13.6797 5.2631 13.8047 5.13807C13.9298 5.01305 14 4.84348 14 4.66667C14 4.48986 13.9298 4.32029 13.8047 4.19526C13.6797 4.07024 13.5101 4 13.3333 4ZM6.66667 3.33334C6.66667 3.15652 6.7369 2.98696 6.86193 2.86193C6.98695 2.73691 7.15652 2.66667 7.33333 2.66667H8.66667C8.84348 2.66667 9.01305 2.73691 9.13807 2.86193C9.2631 2.98696 9.33333 3.15652 9.33333 3.33334V4H6.66667V3.33334ZM11.3333 12.6667C11.3333 12.8435 11.2631 13.0131 11.1381 13.1381C11.013 13.2631 10.8435 13.3333 10.6667 13.3333H5.33333C5.15652 13.3333 4.98695 13.2631 4.86193 13.1381C4.7369 13.0131 4.66667 12.8435 4.66667 12.6667V5.33334H11.3333V12.6667ZM9.33333 12C9.51014 12 9.67971 11.9298 9.80474 11.8047C9.92976 11.6797 10 11.5101 10 11.3333V7.33334C10 7.15653 9.92976 6.98696 9.80474 6.86193C9.67971 6.73691 9.51014 6.66667 9.33333 6.66667C9.15652 6.66667 8.98695 6.73691 8.86193 6.86193C8.73691 6.98696 8.66667 7.15653 8.66667 7.33334V11.3333C8.66667 11.5101 8.73691 11.6797 8.86193 11.8047C8.98695 11.9298 9.15652 12 9.33333 12Z\" fill=\"#E34D5B\"/>\n      </svg>\n      ".concat(initialText);
  }
  deleteButtons.forEach(function (button) {
    return changeDeleteButtonInnerHtml(button);
  });
  var observer = new MutationObserver(function (mutationsList) {
    mutationsList.forEach(function (mutation) {
      if (mutation.addedNodes.length > 0) {
        mutation.addedNodes.forEach(function (node) {
          if (node instanceof Element) {
            if (node.matches('.delete-item-selector')) {
              changeDeleteButtonInnerHtml(node);
            } else {
              var newDeleteButtons = node.querySelectorAll('.delete-item-selector');
              newDeleteButtons.forEach(function (button) {
                return changeDeleteButtonInnerHtml(button);
              });
            }
          }
        });
      }
    });
  });
  observer.observe(document.body, {
    childList: true,
    subtree: true
  });
  /**
   * This function does two main things:
   *
   * 1. Adds a click event listener to the button to control the collapsible flow:
   *    - It finds the closest <label> element related to the button.
   *    - Within that <label>, it looks for an element with the class 'optional-text'. If it finds 'optional-text', it toggles how that text is displayed (either with brackets or an icon).
   *    - It also locates the nearest parent element with the classes 'subelement rounded-t-sm'. If that parent subelement exists, it toggles its state to either collapse or expand the form section.
   *    - Finally, it rotates the collapse button each time it’s clicked.
   *
   * 2. It triggers the button click event if the subelement is optional using the flag: thisButtonBelongsToOptionalForm.
   *    This ensures optional forms start off collapsed by default when rendered.
   *
   * @param button - The button element that manages the collapsible form section.
   */
  function attachCollapsableButtonEvents(button) {
    var label = getClosestLabelDom(button);
    var optionalLabel = label ? getOptionalTextDom(label) : null;
    var subelement = label ? getClosestParentSubelementDom(label) : null;
    var thisButtonBelongsToOptionalForm = optionalLabel !== null;
    button.addEventListener('click', function () {
      if (optionalLabel) {
        toggleOptionalText(optionalLabel);
      }
      if (subelement) {
        toggleAccordionItems(subelement);
      }
      button.classList.toggle('rotate-180');
    });
    if (thisButtonBelongsToOptionalForm && !errorMessageExists(subelement)) {
      button.click();
    }
  }
  /**
   * Check if any error message exists in the subelement.
   *
   * @param subelement
   */
  function errorMessageExists(subelement) {
    var errorDivs = subelement.querySelectorAll('.error');
    var errorTexts = subelement.querySelectorAll('.text-danger-error');
    var _iterator = _createForOfIteratorHelper(errorDivs),
      _step;
    try {
      for (_iterator.s(); !(_step = _iterator.n()).done;) {
        var div = _step.value;
        if (div.textContent.trim() !== '') {
          return true;
        }
      }
    } catch (err) {
      _iterator.e(err);
    } finally {
      _iterator.f();
    }
    var _iterator2 = _createForOfIteratorHelper(errorTexts),
      _step2;
    try {
      for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
        var _div = _step2.value;
        if (_div.textContent.trim() !== '') {
          return true;
        }
      }
    } catch (err) {
      _iterator2.e(err);
    } finally {
      _iterator2.f();
    }
    return false;
  }
  /**
   * Returns closest <label> element.
   *
   * @param button
   */
  function getClosestLabelDom(button) {
    return button.closest('label');
  }
  /**
   * Returns closest element with class 'optional-text'.
   *
   * @param label
   */
  function getOptionalTextDom(label) {
    return label.querySelector('.optional-text');
  }
  /**
   * Returns the first Nth parent that has class 'subelement'.
   *
   * @param label
   */
  function getClosestParentSubelementDom(label) {
    return label.closest('.subelement.rounded-t-sm');
  }
  /**
   * Toggles what is rendered on optional text. (dot or bracket)
   *
   * @param optionalLabel
   */
  function toggleOptionalText(optionalLabel) {
    var optionalLabelWithSvg = '<svg viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9a1.87 1.87 0 1 0 3.74 0A1.87 1.87 0 0 0 6 9Z" fill="#68797E"></path></svg><span>Optional</span>';
    var optionalLabelWithBrackets = '<span>( Optional )</span>';
    var svgExists = optionalLabel.querySelector('svg') !== null;
    if (svgExists) {
      optionalLabel.innerHTML = optionalLabelWithBrackets;
    } else {
      optionalLabel.innerHTML = optionalLabelWithSvg;
    }
  }
  /**
   * Toggles collapsed state. (expand or collapsed)
   *
   * Key considerations:
   * 1. The "Add Additional" button can be either inside or outside the subelement.
   * 2. When the button is outside, it will always be the immediate sibling to the subelement.
   * 3. The collapse mechanism is handled by adjusting the max height to give the illusion of sliding up.
   * 4. If the button is outside the subelement, the slide-up effect will not affect the button.
   *    Therefore, we toggle the 'display-none' class to control its visibility.
   *
   * @param subelement
   */
  function toggleAccordionItems(subelement) {
    function isAddAdditionalButtonOutside(subelement) {
      var nextSibling = subelement.nextElementSibling;
      if (nextSibling && nextSibling.tagName === 'BUTTON') {
        return nextSibling.classList.contains('add_more') && nextSibling.classList.contains('button');
      }
      return false;
    }
    var hideableSubelements = _toConsumableArray(subelement.children).filter(function (child) {
      return child.tagName !== 'LABEL';
    });
    var outsideButton = null;
    var hasAddAdditionalButtonOutside = isAddAdditionalButtonOutside(subelement);
    if (hasAddAdditionalButtonOutside) {
      outsideButton = subelement.nextElementSibling;
      if (outsideButton) {
        outsideButton.classList.toggle('display-none');
      }
    }
    hideableSubelements.forEach(function (child) {
      if (hasAddAdditionalButtonOutside && outsideButton) {
        subelement.classList.toggle('mb-6');
      }
      if (child.classList.contains('height-hide')) {
        child.classList.remove('height-hide');
        child.classList.add('height-show');
      } else {
        child.classList.remove('height-show');
        child.classList.add('height-hide');
      }
    });
  }
  /**
   * This function handles the forms rendered on initial page load.
   */
  function attachInitialCollapsableButtonEvents() {
    var allCollapsableButtons = document.querySelectorAll('.collapsable-button');
    allCollapsableButtons.forEach(function (button) {
      return attachCollapsableButtonEvents(button);
    });
  }
  /**
   * This function handles the forms rendered on clicking 'ADD ADDITIONAL X' button.
   */
  function observeNewCollapsableButtons() {
    var observer = new MutationObserver(function (mutationsList) {
      mutationsList.forEach(function (mutation) {
        if (mutation.type === 'childList') {
          mutation.addedNodes.forEach(function (node) {
            if (node instanceof HTMLElement) {
              var newCollapsableButtons = node.querySelectorAll('.collapsable-button');
              newCollapsableButtons.forEach(function (button) {
                return attachCollapsableButtonEvents(button);
              });
            }
          });
        }
      });
    });
    observer.observe(document.body, {
      childList: true,
      subtree: true
    });
  }
  attachInitialCollapsableButtonEvents();
  observeNewCollapsableButtons();
});
function escapeHtml(unsafe) {
  return unsafe.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
}
/*
 *
 * Help Text Open Close Handlers Start
 *
 */
(0, jquery_1["default"])(document).on('click', function (event) {
  if (!(0, jquery_1["default"])(event.target).closest('.help').length) {
    (0, jquery_1["default"])('.help__text').removeAttr('style');
  }
});
(0, jquery_1["default"])(document).on('click', '.help', function (event) {
  event.stopPropagation();
  console.log('Hello');
  (0, jquery_1["default"])('.help__text').removeAttr('style');
  var helpText = (0, jquery_1["default"])(this).find('.help__text');
  if (helpText.length > 0) {
    helpText.css({
      opacity: '1',
      visibility: 'visible'
    });
  }
  if ((0, jquery_1["default"])(event.target).closest('.close-help').length) {
    closeHelpText(helpText);
  }
});
(0, jquery_1["default"])(document).on('keydown', function (event) {
  if (event.key === 'Escape') {
    (0, jquery_1["default"])('.help__text').each(function () {
      closeHelpText((0, jquery_1["default"])(this));
    });
  }
});
/**
 * Closes the help text tooltip by setting its CSS properties to make it invisible and non-interactive.
 * After a delay, it removes the inline styles to reset the element's state.
 *
 * @param helpText - The jQuery object representing the tooltip element to be closed.
 */
function closeHelpText(helpText) {
  helpText.css({
    'pointer-events': 'none',
    opacity: '0',
    visibility: 'invisible'
  });
  setTimeout(function () {
    helpText.removeAttr('style');
  }, 1000);
}
/*
 *
 * Help Text Open Close Handlers End
 *
 */

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["/js/vendor"], () => (__webpack_exec__("./resources/assets/js/scripts/formbuilder.ts")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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QUNqRSxVQUFVLENBQUMsT0FBTyxDQUFDO0VBQ2hDLENBQUMsRUFBRSxJQUFJLENBQUM7QUFDWjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2pzL3NjcmlwdHMvRHluYW1pY0ZpZWxkLnRzIiwid2VicGFjazovLy8uL3Jlc291cmNlcy9hc3NldHMvanMvc2NyaXB0cy9mb3JtYnVpbGRlci50cyJdLCJzb3VyY2VzQ29udGVudCI6WyJcInVzZSBzdHJpY3RcIjtcbnZhciBfX2ltcG9ydERlZmF1bHQgPSAodGhpcyAmJiB0aGlzLl9faW1wb3J0RGVmYXVsdCkgfHwgZnVuY3Rpb24gKG1vZCkge1xuICAgIHJldHVybiAobW9kICYmIG1vZC5fX2VzTW9kdWxlKSA/IG1vZCA6IHsgXCJkZWZhdWx0XCI6IG1vZCB9O1xufTtcbk9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBcIl9fZXNNb2R1bGVcIiwgeyB2YWx1ZTogdHJ1ZSB9KTtcbmV4cG9ydHMuRHluYW1pY0ZpZWxkID0gdm9pZCAwO1xuY29uc3QganF1ZXJ5XzEgPSBfX2ltcG9ydERlZmF1bHQocmVxdWlyZShcImpxdWVyeVwiKSk7XG5yZXF1aXJlKFwic2VsZWN0MlwiKTtcbmNsYXNzIER5bmFtaWNGaWVsZCB7XG4gICAgLyoqXG4gICAgICogSGlkZSBhbmQgU2hvdyBkaWZmZXJlbnQgZm9ybSBmaWVsZHMgYmFzZWQgb24gdm9jYWJ1bGFyeSBhbmQgb3RoZXIgdHlwZXNcbiAgICAgKi9cbiAgICBoaWRlU2hvd0Zvcm1GaWVsZHMoKSB7XG4gICAgICAgIHRoaXMuaHVtYW5pdGFyaWFuU2NvcGVIaWRlVm9jYWJ1bGFyeVVyaSgpO1xuICAgICAgICB0aGlzLmNvdW50cnlCdWRnZXRIaWRlQ29kZUZpZWxkKCk7XG4gICAgICAgIHRoaXMuYWlkVHlwZVZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgdGhpcy5zZWN0b3JWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIHRoaXMucG9saWN5Vm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICB0aGlzLnJlY2lwaWVudFZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgdGhpcy5zZWN0b3JWb2NhYnVsYXJ5SGlkZUZpZWxkKCk7XG4gICAgICAgIHRoaXMudGFnVm9jYWJ1bGFyeUhpZGVGaWVsZCgpO1xuICAgICAgICB0aGlzLnRyYW5zYWN0aW9uQWlkVHlwZVZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgdGhpcy5pbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGRVcmkoKTtcbiAgICB9XG4gICAgLyoqXG4gICAgICogSHVtYW5pdGFyaWFuIFNjb3BlIEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIGh1bWFuaXRhcmlhblNjb3BlSGlkZVZvY2FidWxhcnlVcmkoKSB7XG4gICAgICAgIGNvbnN0IGh1bWFuaXRhcmlhblNjb3BlVm9jYWJ1bGFyeSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnc2VsZWN0W2lkXj1cImh1bWFuaXRhcmlhbl9zY29wZVwiXVtpZCo9XCJbdm9jYWJ1bGFyeV1cIl0nKTtcbiAgICAgICAgaWYgKGh1bWFuaXRhcmlhblNjb3BlVm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICAvLyBoaWRlIGZpZWxkcyBvbiBwYWdlIGxvYWRcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuZWFjaChodW1hbml0YXJpYW5TY29wZVZvY2FidWxhcnksIChpbmRleCwgc2NvcGUpID0+IHtcbiAgICAgICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICAgICAgY29uc3QgdmFsID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHNjb3BlKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJyc7XG4gICAgICAgICAgICAgICAgdGhpcy5oaWRlSHVtYW5pdGFyaWFuU2NvcGVGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoc2NvcGUpLCB2YWwudG9TdHJpbmcoKSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIC8vIGhpZGUvc2hvdyBmaWVsZHMgb24gdmFsdWUgY2hhbmdlXG4gICAgICAgICAgICBodW1hbml0YXJpYW5TY29wZVZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgKGUpID0+IHtcbiAgICAgICAgICAgICAgICBjb25zdCB2YWwgPSBlLnBhcmFtcy5kYXRhLmlkO1xuICAgICAgICAgICAgICAgIGNvbnN0IGluZGV4ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgdGhpcy5oaWRlSHVtYW5pdGFyaWFuU2NvcGVGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaW5kZXgpLCB2YWwpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAvLyBoaWRlL3Nob3cgZmllbGRzIG9uIHZhbHVlIGNsZWFyXG4gICAgICAgICAgICBodW1hbml0YXJpYW5TY29wZVZvY2FidWxhcnkub24oJ3NlbGVjdDI6Y2xlYXInLCAoZSkgPT4ge1xuICAgICAgICAgICAgICAgIGNvbnN0IGluZGV4ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgdGhpcy5oaWRlSHVtYW5pdGFyaWFuU2NvcGVGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaW5kZXgpLCAnJyk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH1cbiAgICAvLyBoaWRlIGNvdW50cnkgYnVkZ2V0IGJhc2VkIG9uIHZvY2FidWxhcnlcbiAgICBoaWRlSHVtYW5pdGFyaWFuU2NvcGVGaWVsZChpbmRleCwgdmFsdWUpIHtcbiAgICAgICAgY29uc3QgaHVtYW5pdGFyaWFuU2NvcGVIaWRlVm9jYWJ1bGFyeVVyaSA9ICdpbnB1dFtpZF49XCJodW1hbml0YXJpYW5fc2NvcGVcIl1baWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSc7XG4gICAgICAgIGlmICh2YWx1ZSA9PT0gJzk5Jykge1xuICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgIC5maW5kKGh1bWFuaXRhcmlhblNjb3BlSGlkZVZvY2FidWxhcnlVcmkpXG4gICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICB9XG4gICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgIC5maW5kKGh1bWFuaXRhcmlhblNjb3BlSGlkZVZvY2FidWxhcnlVcmkpXG4gICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgIH1cbiAgICB9XG4gICAgLyoqXG4gICAgICogSHVtYW5pdGFyaWFuIFNjb3BlIEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIGluZGljYXRvclJlZmVyZW5jZUhpZGVGaWVsZFVyaSgpIHtcbiAgICAgICAgY29uc3QgcmVmZXJlbmNlVm9jYWJ1bGFyeSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnc2VsZWN0W2lkXj1cInJlZmVyZW5jZVwiXVtpZCo9XCJbdm9jYWJ1bGFyeV1cIl0nKTtcbiAgICAgICAgaWYgKHJlZmVyZW5jZVZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAgLy8gaGlkZSBmaWVsZHMgb24gcGFnZSBsb2FkXG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2gocmVmZXJlbmNlVm9jYWJ1bGFyeSwgKGluZGV4LCBzY29wZSkgPT4ge1xuICAgICAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgICAgICBjb25zdCB2YWwgPSAoX2EgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoc2NvcGUpLnZhbCgpKSAhPT0gbnVsbCAmJiBfYSAhPT0gdm9pZCAwID8gX2EgOiAnJztcbiAgICAgICAgICAgICAgICB0aGlzLmluZGljYXRvclJlZmVyZW5jZUhpZGVGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoc2NvcGUpLCB2YWwudG9TdHJpbmcoKSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIC8vIGhpZGUvc2hvdyBmaWVsZHMgb24gdmFsdWUgY2hhbmdlXG4gICAgICAgICAgICByZWZlcmVuY2VWb2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOnNlbGVjdCcsIChlKSA9PiB7XG4gICAgICAgICAgICAgICAgY29uc3QgdmFsID0gZS5wYXJhbXMuZGF0YS5pZDtcbiAgICAgICAgICAgICAgICBjb25zdCBpbmRleCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIHRoaXMuaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShpbmRleCksIHZhbCk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIC8vIGhpZGUvc2hvdyBmaWVsZHMgb24gdmFsdWUgY2xlYXJcbiAgICAgICAgICAgIHJlZmVyZW5jZVZvY2FidWxhcnkub24oJ3NlbGVjdDI6Y2xlYXInLCAoZSkgPT4ge1xuICAgICAgICAgICAgICAgIGNvbnN0IGluZGV4ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgdGhpcy5pbmRpY2F0b3JSZWZlcmVuY2VIaWRlRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGluZGV4KSwgJycpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9XG4gICAgLy8gaGlkZSBjb3VudHJ5IGJ1ZGdldCBiYXNlZCBvbiB2b2NhYnVsYXJ5XG4gICAgaW5kaWNhdG9yUmVmZXJlbmNlSGlkZUZpZWxkKGluZGV4LCB2YWx1ZSkge1xuICAgICAgICBjb25zdCByZWZlcmVuY2VVcmkgPSAnaW5wdXRbaWRePVwicmVmZXJlbmNlXCJdW2lkKj1cIltpbmRpY2F0b3JfdXJpXVwiXSc7XG4gICAgICAgIGlmICh2YWx1ZSA9PT0gJzk5Jykge1xuICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgIC5maW5kKHJlZmVyZW5jZVVyaSlcbiAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgIH1cbiAgICAgICAgZWxzZSB7XG4gICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgLmZpbmQocmVmZXJlbmNlVXJpKVxuICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICB9XG4gICAgfVxuICAgIC8qKlxuICAgICAqIENvdW50cnkgQnVkZ2V0IEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIHNob3cvaGlkZSAnY29kZScgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIGNvdW50cnlCdWRnZXRIaWRlQ29kZUZpZWxkKCkge1xuICAgICAgICB2YXIgX2E7XG4gICAgICAgIGNvbnN0IGNvdW50cnlCdWRnZXRWb2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3QjY291bnRyeV9idWRnZXRfdm9jYWJ1bGFyeScpO1xuICAgICAgICBpZiAoY291bnRyeUJ1ZGdldFZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAgLy8gaGlkZS9zaG93IG9uIHBhZ2UgbG9hZFxuICAgICAgICAgICAgY29uc3QgdmFsID0gKF9hID0gY291bnRyeUJ1ZGdldFZvY2FidWxhcnkudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcxJztcbiAgICAgICAgICAgIHRoaXMuaGlkZUNvdW50cnlCdWRnZXRGaWVsZCh2YWwudG9TdHJpbmcoKSk7XG4gICAgICAgICAgICAvLyBoaWRlL3Nob3cgb24gdmFsdWUgY2hhbmdlXG4gICAgICAgICAgICBjb3VudHJ5QnVkZ2V0Vm9jYWJ1bGFyeS5vbignc2VsZWN0MjpzZWxlY3QnLCAoZSkgPT4ge1xuICAgICAgICAgICAgICAgIGNvbnN0IHZhbCA9IGUucGFyYW1zLmRhdGEuaWQ7XG4gICAgICAgICAgICAgICAgdGhpcy5oaWRlQ291bnRyeUJ1ZGdldEZpZWxkKHZhbCk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIC8vaGlkZS9zaG93IGJhc2VkIG9uIHZhbHVlIGNsZWFyZWRcbiAgICAgICAgICAgIGNvdW50cnlCdWRnZXRWb2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgKCkgPT4ge1xuICAgICAgICAgICAgICAgIHRoaXMuaGlkZUNvdW50cnlCdWRnZXRGaWVsZCgnJyk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH1cbiAgICAvKipcbiAgICAgKiBIaWRlIENvdW50cnkgQnVkZ2V0IEZpZWxkc1xuICAgICAqL1xuICAgIGhpZGVDb3VudHJ5QnVkZ2V0RmllbGQodmFsdWUpIHtcbiAgICAgICAgY29uc3QgY291bnRyeUJ1ZGdldENvZGVJbnB1dCA9ICdpbnB1dFtpZF49XCJidWRnZXRfaXRlbVwiXVtpZCo9XCJbY29kZV90ZXh0XVwiXScsIGNvdW50cnlCdWRnZXRDb2RlU2VsZWN0ID0gJ3NlbGVjdFtpZF49XCJidWRnZXRfaXRlbVwiXVtpZCo9XCJbY29kZV1cIl0nO1xuICAgICAgICBpZiAodmFsdWUgPT09ICcxJykge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGNvdW50cnlCdWRnZXRDb2RlU2VsZWN0KVxuICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoY291bnRyeUJ1ZGdldENvZGVJbnB1dClcbiAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgfVxuICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShjb3VudHJ5QnVkZ2V0Q29kZVNlbGVjdClcbiAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShjb3VudHJ5QnVkZ2V0Q29kZUlucHV0KVxuICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICB9XG4gICAgfVxuICAgIC8qKlxuICAgICAqIEFpZFR5cGUgRm9ybSBQYWdlXG4gICAgICpcbiAgICAgKiBATG9naWMgaGlkZSB2b2NhYnVsYXJ5LXVyaSBhbmQgY29kZXMgZmllbGQgYmFzZWQgb24gJ0B2b2NhYnVsYXJ5JyBmaWVsZCB2YWx1ZVxuICAgICAqL1xuICAgIGFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkKCkge1xuICAgICAgICBjb25zdCBhaWR0eXBlX3ZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdFtpZCo9XCJkZWZhdWx0X2FpZF90eXBlX3ZvY2FidWxhcnlcIl0nKTtcbiAgICAgICAgaWYgKGFpZHR5cGVfdm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2goYWlkdHlwZV92b2NhYnVsYXJ5LCAoaW5kZXgsIGl0ZW0pID0+IHtcbiAgICAgICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICAgICAgY29uc3QgZGF0YSA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShpdGVtKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJzEnO1xuICAgICAgICAgICAgICAgIHRoaXMuaGlkZUFpZFR5cGVTZWxlY3RGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaXRlbSksIGRhdGEudG9TdHJpbmcoKSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIGFpZHR5cGVfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpzZWxlY3QnLCAoZSkgPT4ge1xuICAgICAgICAgICAgICAgIGNvbnN0IGRhdGEgPSBlLnBhcmFtcy5kYXRhLmlkO1xuICAgICAgICAgICAgICAgIGNvbnN0IHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIHRoaXMuaGlkZUFpZFR5cGVTZWxlY3RGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgZGF0YSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIGFpZHR5cGVfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpjbGVhcicsIChlKSA9PiB7XG4gICAgICAgICAgICAgICAgY29uc3QgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgdGhpcy5oaWRlQWlkVHlwZVNlbGVjdEZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCAnJyk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH1cbiAgICAvKipcbiAgICAgKiBBaWRUeXBlIEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgYW5kIGNvZGVzIGZpZWxkIGJhc2VkIG9uICdAdm9jYWJ1bGFyeScgZmllbGQgdmFsdWVcbiAgICAgKi9cbiAgICB0cmFuc2FjdGlvbkFpZFR5cGVWb2NhYnVsYXJ5SGlkZUZpZWxkKCkge1xuICAgICAgICBjb25zdCBhaWR0eXBlX3ZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdFtpZCo9XCJhaWRfdHlwZV92b2NhYnVsYXJ5XCJdJyk7XG4gICAgICAgIGlmIChhaWR0eXBlX3ZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAganF1ZXJ5XzEuZGVmYXVsdC5lYWNoKGFpZHR5cGVfdm9jYWJ1bGFyeSwgKGluZGV4LCBpdGVtKSA9PiB7XG4gICAgICAgICAgICAgICAgdmFyIF9hO1xuICAgICAgICAgICAgICAgIGNvbnN0IGRhdGEgPSAoX2EgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaXRlbSkudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcxJztcbiAgICAgICAgICAgICAgICB0aGlzLmhpZGVUcmFuc2FjdGlvbkFpZFR5cGVTZWxlY3RGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoaXRlbSksIGRhdGEudG9TdHJpbmcoKSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIGFpZHR5cGVfdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpzZWxlY3QnLCAoZSkgPT4ge1xuICAgICAgICAgICAgICAgIGNvbnN0IGRhdGEgPSBlLnBhcmFtcy5kYXRhLmlkO1xuICAgICAgICAgICAgICAgIGNvbnN0IHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIHRoaXMuaGlkZVRyYW5zYWN0aW9uQWlkVHlwZVNlbGVjdEZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCBkYXRhKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgYWlkdHlwZV92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgKGUpID0+IHtcbiAgICAgICAgICAgICAgICBjb25zdCB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICB0aGlzLmhpZGVUcmFuc2FjdGlvbkFpZFR5cGVTZWxlY3RGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgJycpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9XG4gICAgLyoqXG4gICAgICogSGlkZSBBaWQgVHlwZSBTZWxlY3QgRmllbGRzXG4gICAgICovXG4gICAgaGlkZUFpZFR5cGVTZWxlY3RGaWVsZChpbmRleCwgdmFsdWUpIHtcbiAgICAgICAgY29uc3QgZGVmYXVsdF9haWRfdHlwZSA9ICdzZWxlY3RbaWQqPVwiW2RlZmF1bHRfYWlkX3R5cGVdXCJdJywgZWFybWFya2luZ19jYXRlZ29yeSA9ICdzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfY2F0ZWdvcnldXCJdJywgZWFybWFya2luZ19tb2RhbGl0eSA9ICdzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfbW9kYWxpdHldXCJdJywgY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzID0gJ3NlbGVjdFtpZCo9XCJbY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzXVwiXScsIGNhc2UxID0gJ3NlbGVjdFtpZCo9XCJbZWFybWFya2luZ19jYXRlZ29yeV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX21vZGFsaXR5XVwiXSxzZWxlY3RbaWQqPVwiW2Nhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllc11cIl0nLCBjYXNlMiA9ICdzZWxlY3RbaWQqPVwiW2RlZmF1bHRfYWlkX3R5cGVdXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19tb2RhbGl0eV1cIl0sc2VsZWN0W2lkKj1cIltjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXNdXCJdJywgY2FzZTMgPSAnc2VsZWN0W2lkKj1cIltkZWZhdWx0X2FpZF90eXBlXVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfY2F0ZWdvcnldXCJdLHNlbGVjdFtpZCo9XCJbY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzXVwiXScsIGNhc2U0ID0gJ3NlbGVjdFtpZCo9XCJbZGVmYXVsdF9haWRfdHlwZV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX2NhdGVnb3J5XVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfbW9kYWxpdHldXCJdJztcbiAgICAgICAgc3dpdGNoICh2YWx1ZSkge1xuICAgICAgICAgICAgY2FzZSAnMic6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoZWFybWFya2luZ19jYXRlZ29yeSlcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnMyc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoZWFybWFya2luZ19tb2RhbGl0eSlcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UzKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnNCc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTQpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBkZWZhdWx0OlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGRlZmF1bHRfYWlkX3R5cGUpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgfVxuICAgIH1cbiAgICAvKipcbiAgICAgKiBIaWRlIFRyYW5zYWN0aW9uIEFpZCBUeXBlIFNlbGVjdCBGaWVsZHNcbiAgICAgKi9cbiAgICBoaWRlVHJhbnNhY3Rpb25BaWRUeXBlU2VsZWN0RmllbGQoaW5kZXgsIHZhbHVlKSB7XG4gICAgICAgIGNvbnN0IGFpZF90eXBlID0gJ3NlbGVjdFtpZCo9XCJbYWlkX3R5cGVfY29kZV1cIl0nLCBlYXJtYXJraW5nX2NhdGVnb3J5ID0gJ3NlbGVjdFtpZCo9XCJbZWFybWFya2luZ19jYXRlZ29yeV1cIl0nLCBlYXJtYXJraW5nX21vZGFsaXR5ID0gJ3NlbGVjdFtpZCo9XCJbZWFybWFya2luZ19tb2RhbGl0eV1cIl0nLCBjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXMgPSAnc2VsZWN0W2lkKj1cIltjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXNdXCJdJywgY2FzZTEgPSAnc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX2NhdGVnb3J5XVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfbW9kYWxpdHldXCJdLHNlbGVjdFtpZCo9XCJbY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzXVwiXScsIGNhc2UyID0gJ3NlbGVjdFtpZCo9XCJbYWlkX3R5cGVfY29kZV1cIl0sc2VsZWN0W2lkKj1cIltlYXJtYXJraW5nX21vZGFsaXR5XVwiXSxzZWxlY3RbaWQqPVwiW2Nhc2hfYW5kX3ZvdWNoZXJfbW9kYWxpdGllc11cIl0nLCBjYXNlMyA9ICdzZWxlY3RbaWQqPVwiW2FpZF90eXBlX2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19jYXRlZ29yeV1cIl0sc2VsZWN0W2lkKj1cIltjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXNdXCJdJywgY2FzZTQgPSAnc2VsZWN0W2lkKj1cIlthaWRfdHlwZV9jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW2Vhcm1hcmtpbmdfY2F0ZWdvcnldXCJdLHNlbGVjdFtpZCo9XCJbZWFybWFya2luZ19tb2RhbGl0eV1cIl0nO1xuICAgICAgICBzd2l0Y2ggKHZhbHVlKSB7XG4gICAgICAgICAgICBjYXNlICcyJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChlYXJtYXJraW5nX2NhdGVnb3J5KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTIpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICczJzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChlYXJtYXJraW5nX21vZGFsaXR5KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTMpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlICc0JzpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNoX2FuZF92b3VjaGVyX21vZGFsaXRpZXMpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlNClcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGRlZmF1bHQ6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoYWlkX3R5cGUpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgfVxuICAgIH1cbiAgICAvKipcbiAgICAgKiBQb2xpY3kgTWFya2VyIEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgYW5kIGNvZGVzIGZpZWxkIGJhc2VkIG9uICdAdm9jYWJ1bGFyeScgZmllbGQgdmFsdWVcbiAgICAgKi9cbiAgICBwb2xpY3lWb2NhYnVsYXJ5SGlkZUZpZWxkKCkge1xuICAgICAgICBjb25zdCBwb2xpY3ltYWtlcl92b2NhYnVsYXJ5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdzZWxlY3RbaWQqPVwicG9saWN5X21hcmtlcl92b2NhYnVsYXJ5XCJdJyk7XG4gICAgICAgIGlmIChwb2xpY3ltYWtlcl92b2NhYnVsYXJ5Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuZWFjaChwb2xpY3ltYWtlcl92b2NhYnVsYXJ5LCAoaW5kZXgsIHBvbGljeV9tYXJrZXIpID0+IHtcbiAgICAgICAgICAgICAgICB2YXIgX2E7XG4gICAgICAgICAgICAgICAgY29uc3QgZGF0YSA9IChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShwb2xpY3lfbWFya2VyKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJzEnO1xuICAgICAgICAgICAgICAgIHRoaXMuaGlkZVBvbGljeU1ha2VyRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHBvbGljeV9tYXJrZXIpLCBkYXRhLnRvU3RyaW5nKCkpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICBwb2xpY3ltYWtlcl92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOnNlbGVjdCcsIChlKSA9PiB7XG4gICAgICAgICAgICAgICAgY29uc3QgZGF0YSA9IGUucGFyYW1zLmRhdGEuaWQ7XG4gICAgICAgICAgICAgICAgY29uc3QgdGFyZ2V0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgdGhpcy5oaWRlUG9saWN5TWFrZXJGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgZGF0YSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIHBvbGljeW1ha2VyX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6Y2xlYXInLCAoZSkgPT4ge1xuICAgICAgICAgICAgICAgIGNvbnN0IHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIHRoaXMuaGlkZVBvbGljeU1ha2VyRmllbGQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCksICc5OScpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9XG4gICAgLyoqXG4gICAgICogSGlkZXMgUG9saWN5IE1hcmtlciBGb3JtIEZpZWxkc1xuICAgICAqL1xuICAgIGhpZGVQb2xpY3lNYWtlckZpZWxkKGluZGV4LCB2YWx1ZSkge1xuICAgICAgICBjb25zdCBjYXNlMV9zaG93ID0gJ3NlbGVjdFtpZCo9XCJbcG9saWN5X21hcmtlcl1cIl0nLCBjYXNlMl9zaG93ID0gJ2lucHV0W2lkKj1cIltwb2xpY3lfbWFya2VyX3RleHRdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0nLCBjYXNlMSA9ICdpbnB1dFtpZCo9XCJbcG9saWN5X21hcmtlcl90ZXh0XVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdJywgY2FzZTIgPSAnc2VsZWN0W2lkKj1cIltwb2xpY3lfbWFya2VyXVwiXSc7XG4gICAgICAgIHN3aXRjaCAodmFsdWUpIHtcbiAgICAgICAgICAgIGNhc2UgJzEnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxX3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKClcbiAgICAgICAgICAgICAgICAgICAgLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGNhc2UgJzk5JzpcbiAgICAgICAgICAgIGRlZmF1bHQ6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTJfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICB9XG4gICAgfVxuICAgIC8qKlxuICAgICAqIFNlY3RvciBGb3JtIFBhZ2VcbiAgICAgKlxuICAgICAqIEBMb2dpYyBoaWRlIHZvY2FidWxhcnktdXJpIGFuZCBjb2RlcyBmaWVsZCBiYXNlZCBvbiAnQHZvY2FidWxhcnknIGZpZWxkIHZhbHVlXG4gICAgICovXG4gICAgc2VjdG9yVm9jYWJ1bGFyeUhpZGVGaWVsZCgpIHtcbiAgICAgICAgY29uc3Qgc2VjdG9yX3ZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdFtpZCo9XCJzZWN0b3Jfdm9jYWJ1bGFyeVwiXScpO1xuICAgICAgICBpZiAoc2VjdG9yX3ZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAganF1ZXJ5XzEuZGVmYXVsdC5lYWNoKHNlY3Rvcl92b2NhYnVsYXJ5LCAoaW5kZXgsIHNlY3RvcikgPT4ge1xuICAgICAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgICAgICBjb25zdCBkYXRhID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHNlY3RvcikudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcxJztcbiAgICAgICAgICAgICAgICB0aGlzLmhpZGVTZWN0b3JGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoc2VjdG9yKSwgZGF0YS50b1N0cmluZygpKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgc2VjdG9yX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgKGUpID0+IHtcbiAgICAgICAgICAgICAgICBjb25zdCBkYXRhID0gZS5wYXJhbXMuZGF0YS5pZDtcbiAgICAgICAgICAgICAgICBjb25zdCB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICB0aGlzLmhpZGVTZWN0b3JGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgZGF0YSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIHNlY3Rvcl92b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgKGUpID0+IHtcbiAgICAgICAgICAgICAgICBjb25zdCB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICB0aGlzLmhpZGVTZWN0b3JGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgJycpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9XG4gICAgLyoqXG4gICAgICogSGlkZSBTZWN0b3IgRm9ybSBmaWVsZHNcbiAgICAgKi9cbiAgICBoaWRlU2VjdG9yRmllbGQoaW5kZXgsIHZhbHVlKSB7XG4gICAgICAgIGNvbnN0IGNhc2UxX3Nob3cgPSAnc2VsZWN0W2lkKj1cIltjb2RlXVwiXScsIGNhc2UyX3Nob3cgPSAnc2VsZWN0W2lkKj1cIltjYXRlZ29yeV9jb2RlXVwiXScsIGNhc2U3X3Nob3cgPSAnc2VsZWN0W2lkKj1cIltzZGdfZ29hbF1cIl0nLCBjYXNlOF9zaG93ID0gJ3NlbGVjdFtpZCo9XCJbc2RnX3RhcmdldF1cIl0nLCBjYXNlOThfOTlfc2hvdyA9ICdpbnB1dFtpZCo9XCJbdGV4dF1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXScsIGRlZmF1bHRfc2hvdyA9ICdpbnB1dFtpZCo9XCJbdGV4dF1cIl0nLCBjYXNlMSA9ICdzZWxlY3RbaWQqPVwiW2NhdGVnb3J5X2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX2dvYWxdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX3RhcmdldF1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSxpbnB1dFtpZCo9XCJbdGV4dF1cIl0nLCBjYXNlMiA9ICdpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdLHNlbGVjdFtpZCo9XCJbc2RnX2dvYWxdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX3RhcmdldF1cIl0sc2VsZWN0W2lkKj1cIltjb2RlXVwiXSxpbnB1dFtpZCo9XCJbdGV4dF1cIl0nLCBjYXNlNyA9ICdpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdLHNlbGVjdFtpZCo9XCJbY2F0ZWdvcnlfY29kZV1cIl0sc2VsZWN0W2lkKj1cIltzZGdfdGFyZ2V0XVwiXSxzZWxlY3RbaWQqPVwiW2NvZGVdXCJdLGlucHV0W2lkKj1cIlt0ZXh0XVwiXScsIGNhc2U4ID0gJ2lucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0sc2VsZWN0W2lkKj1cIltjYXRlZ29yeV9jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW3NkZ19nb2FsXVwiXSxzZWxlY3RbaWQqPVwiW2NvZGVdXCJdLGlucHV0W2lkKj1cIlt0ZXh0XVwiXScsIGNhc2U5OF85OSA9ICdzZWxlY3RbaWQqPVwiW2NhdGVnb3J5X2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX2dvYWxdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX3RhcmdldF1cIl0sc2VsZWN0W2lkKj1cIltjb2RlXVwiXScsIGRlZmF1bHRfaGlkZSA9ICdzZWxlY3RbaWQqPVwiW2NhdGVnb3J5X2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX2dvYWxdXCJdLHNlbGVjdFtpZCo9XCJbc2RnX3RhcmdldF1cIl0sc2VsZWN0W2lkKj1cIltjb2RlXVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdJztcbiAgICAgICAgc3dpdGNoICh2YWx1ZSkge1xuICAgICAgICAgICAgY2FzZSAnMSc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTFfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnMic6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTJfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnNyc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTdfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U3KVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnOCc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZThfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U4KVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnOTgnOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U5OF85OV9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTk4Xzk5KVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnOTknOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U5OF85OV9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTk4Xzk5KVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgZGVmYXVsdDpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChkZWZhdWx0X3Nob3cpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KClcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKTtcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChkZWZhdWx0X2hpZGUpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgIH1cbiAgICB9XG4gICAgLyoqXG4gICAgICogIFJlY2lwaWVudCBWb2NhYnVsYXJ5IEZvcm0gUGFnZVxuICAgICAqXG4gICAgICogQExvZ2ljIGhpZGUgdm9jYWJ1bGFyeS11cmkgYW5kIGNvZGVzIGZpZWxkIGJhc2VkIG9uICdAdm9jYWJ1bGFyeScgZmllbGQgdmFsdWVcbiAgICAgKi9cbiAgICByZWNpcGllbnRWb2NhYnVsYXJ5SGlkZUZpZWxkKCkge1xuICAgICAgICBjb25zdCByZWdpb25fdm9jYWJ1bGFyeSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnc2VsZWN0W2lkKj1cInJlZ2lvbl92b2NhYnVsYXJ5XCJdJyk7XG4gICAgICAgIGlmIChyZWdpb25fdm9jYWJ1bGFyeS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBqcXVlcnlfMS5kZWZhdWx0LmVhY2gocmVnaW9uX3ZvY2FidWxhcnksIChpbmRleCwgcmVnaW9uX3ZvY2FiKSA9PiB7XG4gICAgICAgICAgICAgICAgdmFyIF9hO1xuICAgICAgICAgICAgICAgIGNvbnN0IGRhdGEgPSAoX2EgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkocmVnaW9uX3ZvY2FiKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJzEnO1xuICAgICAgICAgICAgICAgIHRoaXMuaGlkZVJlY2lwaWVudFJlZ2lvbkZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShyZWdpb25fdm9jYWIpLCBkYXRhLnRvU3RyaW5nKCkpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICByZWdpb25fdm9jYWJ1bGFyeS5vbignc2VsZWN0MjpzZWxlY3QnLCAoZSkgPT4ge1xuICAgICAgICAgICAgICAgIGNvbnN0IGRhdGEgPSBlLnBhcmFtcy5kYXRhLmlkO1xuICAgICAgICAgICAgICAgIGNvbnN0IHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIHRoaXMuaGlkZVJlY2lwaWVudFJlZ2lvbkZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCBkYXRhKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgcmVnaW9uX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6Y2xlYXInLCAoZSkgPT4ge1xuICAgICAgICAgICAgICAgIGNvbnN0IHRhcmdldCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgICAgIHRoaXMuaGlkZVJlY2lwaWVudFJlZ2lvbkZpZWxkKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLCAnJyk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH1cbiAgICAvKipcbiAgICAgKiBIaWRlcyBSZWNpcGllbnQgUmVnaW9uIEZvcm0gRmllbGRzXG4gICAgICovXG4gICAgaGlkZVJlY2lwaWVudFJlZ2lvbkZpZWxkKGluZGV4LCB2YWx1ZSkge1xuICAgICAgICBjb25zdCBjYXNlMV9zaG93ID0gJ3NlbGVjdFtpZCo9XCJbcmVnaW9uX2NvZGVdXCJdJywgY2FzZTJfc2hvdyA9ICdpbnB1dFtpZCo9XCJbY3VzdG9tX2NvZGVdXCJdLCBpbnB1dFtpZCo9XCJbY29kZV1cIl0nLCBjYXNlOTlfc2hvdyA9ICdpbnB1dFtpZCo9XCJbY3VzdG9tX2NvZGVdXCJdLGlucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0sIGlucHV0W2lkKj1cIltjb2RlXVwiXScsIGNhc2UxID0gJ2lucHV0W2lkKj1cIltjdXN0b21fY29kZV1cIl0saW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSxpbnB1dFtpZCo9XCJbY29kZV1cIl0nLCBjYXNlMiA9ICdzZWxlY3RbaWQqPVwiW3JlZ2lvbl9jb2RlXVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdJywgY2FzZTk5ID0gJ3NlbGVjdFtpZCo9XCJbcmVnaW9uX2NvZGVdXCJdJztcbiAgICAgICAgc3dpdGNoICh2YWx1ZSkge1xuICAgICAgICAgICAgY2FzZSAnMSc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTFfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnMic6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTJfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnOTknOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U5OV9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTk5KVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgZGVmYXVsdDpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMl9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTIpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgIH1cbiAgICB9XG4gICAgLyoqXG4gICAgICogVXBkYXRlcyBBY3Rpdml0eSBpZGVudGlmaWVyXG4gICAgICovXG4gICAgdXBkYXRlQWN0aXZpdHlJZGVudGlmaWVyKCkge1xuICAgICAgICBjb25zdCBhY3Rpdml0eV9pZGVudGlmaWVyID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjYWN0aXZpdHlfaWRlbnRpZmllcicpO1xuICAgICAgICBpZiAoYWN0aXZpdHlfaWRlbnRpZmllci5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBhY3Rpdml0eV9pZGVudGlmaWVyLm9uKCdrZXl1cCcsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNpYXRpX2lkZW50aWZpZXJfdGV4dCcpLnZhbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5pZGVudGlmaWVyJykuYXR0cignYWN0aXZpdHlfaWRlbnRpZmllcicpICsgYC0keygwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS52YWwoKX1gKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfVxuICAgIC8qKlxuICAgICAqIFRhZyBGb3JtIFBhZ2VcbiAgICAgKlxuICAgICAqIEBMb2dpYyBoaWRlIHZvY2FidWxhcnktdXJpIGFuZCBjb2RlcyBmaWVsZCBiYXNlZCBvbiAnQHZvY2FidWxhcnknIGZpZWxkIHZhbHVlXG4gICAgICovXG4gICAgdGFnVm9jYWJ1bGFyeUhpZGVGaWVsZCgpIHtcbiAgICAgICAgY29uc3QgdGFnX3ZvY2FidWxhcnkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3NlbGVjdFtpZCo9XCJ0YWdfdm9jYWJ1bGFyeVwiXScpO1xuICAgICAgICBpZiAodGFnX3ZvY2FidWxhcnkubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAganF1ZXJ5XzEuZGVmYXVsdC5lYWNoKHRhZ192b2NhYnVsYXJ5LCAoaW5kZXgsIHRhZykgPT4ge1xuICAgICAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgICAgICBjb25zdCBkYXRhID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhZykudmFsKCkpICE9PSBudWxsICYmIF9hICE9PSB2b2lkIDAgPyBfYSA6ICcxJztcbiAgICAgICAgICAgICAgICB0aGlzLmhpZGVUYWdGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFnKSwgZGF0YS50b1N0cmluZygpKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgdGFnX3ZvY2FidWxhcnkub24oJ3NlbGVjdDI6c2VsZWN0JywgKGUpID0+IHtcbiAgICAgICAgICAgICAgICBjb25zdCBkYXRhID0gZS5wYXJhbXMuZGF0YS5pZDtcbiAgICAgICAgICAgICAgICBjb25zdCB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICB0aGlzLmhpZGVUYWdGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgZGF0YSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIHRhZ192b2NhYnVsYXJ5Lm9uKCdzZWxlY3QyOmNsZWFyJywgKGUpID0+IHtcbiAgICAgICAgICAgICAgICBjb25zdCB0YXJnZXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICB0aGlzLmhpZGVUYWdGaWVsZCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KSwgJycpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9XG4gICAgLyoqXG4gICAgICogSGlkZSBUYWcgRm9ybSBmaWVsZHNcbiAgICAgKi9cbiAgICBoaWRlVGFnRmllbGQoaW5kZXgsIHZhbHVlKSB7XG4gICAgICAgIGNvbnN0IGNhc2UxX3Nob3cgPSAnaW5wdXRbaWQqPVwiW3RhZ190ZXh0XVwiXScsIGNhc2UyX3Nob3cgPSAnc2VsZWN0W2lkKj1cIltnb2Fsc190YWdfY29kZV1cIl0nLCBjYXNlM19zaG93ID0gJ3NlbGVjdFtpZCo9XCJbdGFyZ2V0c190YWdfY29kZV1cIl0nLCBjYXNlOTlfc2hvdyA9ICdpbnB1dFtpZCo9XCJbdGFnX3RleHRdXCJdLCBpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdJywgY2FzZTEgPSAnc2VsZWN0W2lkKj1cIltnb2Fsc190YWdfY29kZV1cIl0sc2VsZWN0W2lkKj1cIlt0YXJnZXRzX3RhZ19jb2RlXVwiXSxpbnB1dFtpZCo9XCJbdm9jYWJ1bGFyeV91cmldXCJdJywgY2FzZTIgPSAnaW5wdXRbaWQqPVwiW3ZvY2FidWxhcnlfdXJpXVwiXSxzZWxlY3RbaWQqPVwiW3RhcmdldHNfdGFnX2NvZGVdXCJdLHNlbGVjdFtpZCo9XCJbdGFyZ2V0c190YWdfY29kZV1cIl0saW5wdXRbaWQqPVwiW3RhZ190ZXh0XVwiXScsIGNhc2UzID0gJ2lucHV0W2lkKj1cIlt2b2NhYnVsYXJ5X3VyaV1cIl0sc2VsZWN0W2lkKj1cIltnb2Fsc190YWdfY29kZV1cIl0saW5wdXRbaWQqPVwiW3RhZ190ZXh0XVwiXScsIGNhc2U5OSA9ICdzZWxlY3RbaWQqPVwiW2dvYWxzX3RhZ19jb2RlXVwiXSxzZWxlY3RbaWQqPVwiW3RhcmdldHNfdGFnX2NvZGVdXCJdJztcbiAgICAgICAgc3dpdGNoICh2YWx1ZSkge1xuICAgICAgICAgICAgY2FzZSAnMSc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTFfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UxKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnMic6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTJfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UyKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnMyc6XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTNfc2hvdylcbiAgICAgICAgICAgICAgICAgICAgLnNob3coKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cignZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpO1xuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2UzKVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAnOTknOlxuICAgICAgICAgICAgICAgIGluZGV4XG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgIC5maW5kKGNhc2U5OV9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTk5KVxuICAgICAgICAgICAgICAgICAgICAudmFsKCcnKVxuICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJylcbiAgICAgICAgICAgICAgICAgICAgLmhpZGUoKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKVxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgZGVmYXVsdDpcbiAgICAgICAgICAgICAgICBpbmRleFxuICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAuZmluZChjYXNlMV9zaG93KVxuICAgICAgICAgICAgICAgICAgICAuc2hvdygpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5zaG93KCk7XG4gICAgICAgICAgICAgICAgaW5kZXhcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoY2FzZTEpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZSgpXG4gICAgICAgICAgICAgICAgICAgIC5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpXG4gICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZCcpXG4gICAgICAgICAgICAgICAgICAgIC5oaWRlKCk7XG4gICAgICAgIH1cbiAgICB9XG59XG5leHBvcnRzLkR5bmFtaWNGaWVsZCA9IER5bmFtaWNGaWVsZDtcbi8qXG4gKlxuICogSGVscCBUZXh0IE9wZW4gQ2xvc2UgSGFuZGxlcnMgU3RhcnRcbiAqXG4gKi9cbigwLCBqcXVlcnlfMS5kZWZhdWx0KShkb2N1bWVudCkub24oJ2NsaWNrJywgZnVuY3Rpb24gKGV2ZW50KSB7XG4gICAgaWYgKCEoMCwganF1ZXJ5XzEuZGVmYXVsdCkoZXZlbnQudGFyZ2V0KS5jbG9zZXN0KCcuaGVscCcpLmxlbmd0aCkge1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5oZWxwX190ZXh0JykucmVtb3ZlQXR0cignc3R5bGUnKTtcbiAgICB9XG59KTtcbigwLCBqcXVlcnlfMS5kZWZhdWx0KShkb2N1bWVudCkub24oJ2NsaWNrJywgJy5oZWxwJywgZnVuY3Rpb24gKGV2ZW50KSB7XG4gICAgZXZlbnQuc3RvcFByb3BhZ2F0aW9uKCk7XG4gICAgY29uc29sZS5sb2coJ0hlbGxvJyk7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuaGVscF9fdGV4dCcpLnJlbW92ZUF0dHIoJ3N0eWxlJyk7XG4gICAgY29uc3QgaGVscFRleHQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykuZmluZCgnLmhlbHBfX3RleHQnKTtcbiAgICBpZiAoaGVscFRleHQubGVuZ3RoID4gMCkge1xuICAgICAgICBoZWxwVGV4dC5jc3Moe1xuICAgICAgICAgICAgb3BhY2l0eTogJzEnLFxuICAgICAgICAgICAgdmlzaWJpbGl0eTogJ3Zpc2libGUnLFxuICAgICAgICB9KTtcbiAgICB9XG4gICAgaWYgKCgwLCBqcXVlcnlfMS5kZWZhdWx0KShldmVudC50YXJnZXQpLmNsb3Nlc3QoJy5jbG9zZS1oZWxwJykubGVuZ3RoKSB7XG4gICAgICAgIGNsb3NlSGVscFRleHQoaGVscFRleHQpO1xuICAgIH1cbn0pO1xuKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGRvY3VtZW50KS5vbigna2V5ZG93bicsIGZ1bmN0aW9uIChldmVudCkge1xuICAgIGlmIChldmVudC5rZXkgPT09ICdFc2NhcGUnKSB7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmhlbHBfX3RleHQnKS5lYWNoKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgIGNsb3NlSGVscFRleHQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpKTtcbiAgICAgICAgfSk7XG4gICAgfVxufSk7XG4vKipcbiAqIENsb3NlcyB0aGUgaGVscCB0ZXh0IHRvb2x0aXAgYnkgc2V0dGluZyBpdHMgQ1NTIHByb3BlcnRpZXMgdG8gbWFrZSBpdCBpbnZpc2libGUgYW5kIG5vbi1pbnRlcmFjdGl2ZS5cbiAqIEFmdGVyIGEgZGVsYXksIGl0IHJlbW92ZXMgdGhlIGlubGluZSBzdHlsZXMgdG8gcmVzZXQgdGhlIGVsZW1lbnQncyBzdGF0ZS5cbiAqXG4gKiBAcGFyYW0gaGVscFRleHQgLSBUaGUgalF1ZXJ5IG9iamVjdCByZXByZXNlbnRpbmcgdGhlIHRvb2x0aXAgZWxlbWVudCB0byBiZSBjbG9zZWQuXG4gKi9cbmZ1bmN0aW9uIGNsb3NlSGVscFRleHQoaGVscFRleHQpIHtcbiAgICBoZWxwVGV4dC5jc3Moe1xuICAgICAgICAncG9pbnRlci1ldmVudHMnOiAnbm9uZScsXG4gICAgICAgIG9wYWNpdHk6ICcwJyxcbiAgICAgICAgdmlzaWJpbGl0eTogJ2ludmlzaWJsZScsXG4gICAgfSk7XG4gICAgc2V0VGltZW91dChmdW5jdGlvbiAoKSB7XG4gICAgICAgIGhlbHBUZXh0LnJlbW92ZUF0dHIoJ3N0eWxlJyk7XG4gICAgfSwgMTAwMCk7XG59XG4vKlxuICpcbiAqIEhlbHAgVGV4dCBPcGVuIENsb3NlIEhhbmRsZXJzIEVuZFxuICpcbiAqL1xuIiwiXCJ1c2Ugc3RyaWN0XCI7XG52YXIgX19pbXBvcnREZWZhdWx0ID0gKHRoaXMgJiYgdGhpcy5fX2ltcG9ydERlZmF1bHQpIHx8IGZ1bmN0aW9uIChtb2QpIHtcbiAgICByZXR1cm4gKG1vZCAmJiBtb2QuX19lc01vZHVsZSkgPyBtb2QgOiB7IFwiZGVmYXVsdFwiOiBtb2QgfTtcbn07XG5PYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgXCJfX2VzTW9kdWxlXCIsIHsgdmFsdWU6IHRydWUgfSk7XG5jb25zdCBheGlvc18xID0gX19pbXBvcnREZWZhdWx0KHJlcXVpcmUoXCJheGlvc1wiKSk7XG5jb25zdCBqcXVlcnlfMSA9IF9faW1wb3J0RGVmYXVsdChyZXF1aXJlKFwianF1ZXJ5XCIpKTtcbnJlcXVpcmUoXCJzZWxlY3QyXCIpO1xuY29uc3QgRHluYW1pY0ZpZWxkXzEgPSByZXF1aXJlKFwiLi9EeW5hbWljRmllbGRcIik7XG5jb25zdCBkeW5hbWljRmllbGQgPSBuZXcgRHluYW1pY0ZpZWxkXzEuRHluYW1pY0ZpZWxkKCk7XG5jbGFzcyBGb3JtQnVpbGRlciB7XG4gICAgLy8gYWRkcyBuZXcgY29sbGVjdGlvbiBvZiBzdWItZWxlbWVudFxuICAgIGFkZEZvcm0oZXYpIHtcbiAgICAgICAgZXYucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgY29uc3QgdGFyZ2V0ID0gZXYudGFyZ2V0O1xuICAgICAgICBjb25zdCBjb250YWluZXIgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdmb3JtX3R5cGUnKVxuICAgICAgICAgICAgPyAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoYC5jb2xsZWN0aW9uLWNvbnRhaW5lcltmb3JtX3R5cGUgPSckeygwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2Zvcm1fdHlwZScpfSddYClcbiAgICAgICAgICAgIDogKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuY29sbGVjdGlvbi1jb250YWluZXInKTtcbiAgICAgICAgY29uc3QgY291bnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdjaGlsZF9jb3VudCcpXG4gICAgICAgICAgICA/IHBhcnNlSW50KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2NoaWxkX2NvdW50JykpICsgMVxuICAgICAgICAgICAgOiAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wYXJlbnQoKS5maW5kKCcuZm9ybS1jaGlsZC1ib2R5JykubGVuZ3RoO1xuICAgICAgICBjb25zdCBwYXJlbnRfY291bnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdwYXJlbnRfY291bnQnKVxuICAgICAgICAgICAgPyBwYXJzZUludCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdwYXJlbnRfY291bnQnKSlcbiAgICAgICAgICAgIDogKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucGFyZW50cygnLm11bHRpLWZvcm0nKS5pbmRleCgpIC0gMTtcbiAgICAgICAgY29uc3Qgd3JhcHBlcl9wYXJlbnRfY291bnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCd3cmFwcGVkX3BhcmVudF9jb3VudCcpXG4gICAgICAgICAgICA/IHBhcnNlSW50KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ3dyYXBwZWRfcGFyZW50X2NvdW50JykpXG4gICAgICAgICAgICA6ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLnBhcmVudHMoJy53cmFwcGVkLWNoaWxkLWJvZHknKS5pbmRleCgpIC0gMTtcbiAgICAgICAgbGV0IHByb3RvID0gY29udGFpbmVyXG4gICAgICAgICAgICAuZGF0YSgncHJvdG90eXBlJylcbiAgICAgICAgICAgIC5yZXBsYWNlKC9fX1BBUkVOVF9OQU1FX18vZywgcGFyZW50X2NvdW50KTtcbiAgICAgICAgaWYgKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2hhc19jaGlsZF9jb2xsZWN0aW9uJykpIHtcbiAgICAgICAgICAgIHByb3RvID0gcHJvdG8ucmVwbGFjZSgvX19XUkFQUEVSX05BTUVfXy9nLCBjb3VudCk7XG4gICAgICAgICAgICBwcm90byA9IHByb3RvLnJlcGxhY2UoL19fTkFNRV9fL2csIDApO1xuICAgICAgICB9XG4gICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgcHJvdG8gPSBwcm90by5yZXBsYWNlKC9fX05BTUVfXy9nLCBjb3VudCk7XG4gICAgICAgICAgICBwcm90byA9IHByb3RvLnJlcGxhY2UoL19fV1JBUFBFUl9OQU1FX18vZywgd3JhcHBlcl9wYXJlbnRfY291bnQpO1xuICAgICAgICB9XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLnByZXYoKS5hcHBlbmQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHByb3RvKSk7XG4gICAgICAgIGlmICgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdoYXNfY2hpbGRfY29sbGVjdGlvbicpKSB7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KVxuICAgICAgICAgICAgICAgIC5wcmV2KCcuc3ViZWxlbWVudCcpXG4gICAgICAgICAgICAgICAgLmNoaWxkcmVuKCcud3JhcHBlZC1jaGlsZC1ib2R5JylcbiAgICAgICAgICAgICAgICAubGFzdCgpXG4gICAgICAgICAgICAgICAgLmZpbmQoJy5hZGRfdG9fY29sbGVjdGlvbicpXG4gICAgICAgICAgICAgICAgLmF0dHIoJ3dyYXBwZWRfcGFyZW50X2NvdW50JywgY291bnQpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldClcbiAgICAgICAgICAgICAgICAucHJldignLnN1YmVsZW1lbnQnKVxuICAgICAgICAgICAgICAgIC5jaGlsZHJlbignLndyYXBwZWQtY2hpbGQtYm9keScpXG4gICAgICAgICAgICAgICAgLmxhc3QoKVxuICAgICAgICAgICAgICAgIC5maW5kKCcuYWRkX3RvX2NvbGxlY3Rpb24nKVxuICAgICAgICAgICAgICAgIC5hdHRyKCdwYXJlbnRfY291bnQnLCBwYXJlbnRfY291bnQpO1xuICAgICAgICB9XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXG4gICAgICAgICAgICAucHJldigpXG4gICAgICAgICAgICAuZmluZCgnLndyYXBwZWQtY2hpbGQtYm9keScpXG4gICAgICAgICAgICAubGFzdCgpXG4gICAgICAgICAgICAuZmluZCgnLmFkZF90b19jb2xsZWN0aW9uJylcbiAgICAgICAgICAgIC5hdHRyKCd3cmFwcGVyX3BhcmVudF9jb3VudCcsIHdyYXBwZXJfcGFyZW50X2NvdW50ICE9PSBudWxsICYmIHdyYXBwZXJfcGFyZW50X2NvdW50ICE9PSB2b2lkIDAgPyB3cmFwcGVyX3BhcmVudF9jb3VudCA6IDApO1xuICAgICAgICBpZiAoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cignZm9ybV90eXBlJykpIHtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLnByZXYoKS5sYXN0KCkuZmluZCgnLnNlbGVjdDInKS5zZWxlY3QyKHtcbiAgICAgICAgICAgICAgICBwbGFjZWhvbGRlcjogJ1NlbGVjdCBhbiBvcHRpb24nLFxuICAgICAgICAgICAgICAgIGFsbG93Q2xlYXI6IHRydWUsXG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKVxuICAgICAgICAgICAgICAgIC5maW5kKCcuc3ViLWF0dHJpYnV0ZScpXG4gICAgICAgICAgICAgICAgLndyYXBBbGwoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCc8ZGl2IGNsYXNzPVwiZm9ybS1maWVsZC1ncm91cCBmbGV4IGZsZXgtd3JhcCBzdWItYXR0cmlidXRlLXdyYXBwZXJcIj48L2Rpdj4nKSk7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KVxuICAgICAgICAgICAgICAgIC5wcmV2KCcuc3ViZWxlbWVudCcpXG4gICAgICAgICAgICAgICAgLmNoaWxkcmVuKCcud3JhcHBlZC1jaGlsZC1ib2R5JylcbiAgICAgICAgICAgICAgICAubGFzdCgpXG4gICAgICAgICAgICAgICAgLmZpbmQoJy5zdWItYXR0cmlidXRlJylcbiAgICAgICAgICAgICAgICAud3JhcEFsbCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJzxkaXYgY2xhc3M9XCJmb3JtLWZpZWxkLWdyb3VwIGZsZXggZmxleC13cmFwIHN1Yi1hdHRyaWJ1dGUtd3JhcHBlciBtdC02XCI+PC9kaXY+JykpO1xuICAgICAgICB9XG4gICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldClcbiAgICAgICAgICAgICAgICAucGFyZW50KClcbiAgICAgICAgICAgICAgICAuZmluZCgnLmZvcm0tY2hpbGQtYm9keScpXG4gICAgICAgICAgICAgICAgLmxhc3QoKVxuICAgICAgICAgICAgICAgIC5maW5kKCcuc2VsZWN0MicpXG4gICAgICAgICAgICAgICAgLnNlbGVjdDIoe1xuICAgICAgICAgICAgICAgIHBsYWNlaG9sZGVyOiAnU2VsZWN0IGFuIG9wdGlvbicsXG4gICAgICAgICAgICAgICAgYWxsb3dDbGVhcjogdHJ1ZSxcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2NoaWxkX2NvdW50JywgY291bnQpO1xuICAgICAgICBkeW5hbWljRmllbGQuYWlkVHlwZVZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgZHluYW1pY0ZpZWxkLnNlY3RvclZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICB9XG4gICAgLy8gYWRkcyBwYXJlbnQgY29sbGVjdGlvblxuICAgIGFkZFBhcmVudEZvcm0oZXYpIHtcbiAgICAgICAgZXYucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgY29uc3QgdGFyZ2V0ID0gZXYudGFyZ2V0O1xuICAgICAgICBjb25zdCBjb250YWluZXIgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdmb3JtX3R5cGUnKVxuICAgICAgICAgICAgPyAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoYC5wYXJlbnQtY29sbGVjdGlvbltmb3JtX3R5cGUgPSckeygwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmF0dHIoJ2Zvcm1fdHlwZScpfSddYClcbiAgICAgICAgICAgIDogKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcucGFyZW50LWNvbGxlY3Rpb24nKTtcbiAgICAgICAgY29uc3QgY291bnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdwYXJlbnRfY291bnQnKVxuICAgICAgICAgICAgPyBwYXJzZUludCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5hdHRyKCdwYXJlbnRfY291bnQnKSkgKyAxXG4gICAgICAgICAgICA6ICgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wcmV2KCkuZmluZCgnLm11bHRpLWZvcm0nKS5sZW5ndGhcbiAgICAgICAgICAgICAgICA/ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLnByZXYoKS5maW5kKCcubXVsdGktZm9ybScpLmxlbmd0aFxuICAgICAgICAgICAgICAgIDogKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkucHJldigpLmZpbmQoJy53cmFwcGVkLWNoaWxkLWJvZHknKS5sZW5ndGgpICsgMTtcbiAgICAgICAgbGV0IHByb3RvID0gY29udGFpbmVyLmRhdGEoJ3Byb3RvdHlwZScpLnJlcGxhY2UoL19fUEFSRU5UX05BTUVfXy9nLCBjb3VudCk7XG4gICAgICAgIHByb3RvID0gcHJvdG8ucmVwbGFjZSgvX19OQU1FX18vZywgMCk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLnByZXYoKS5hcHBlbmQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHByb3RvKSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLnByZXYoKS5maW5kKCcubXVsdGktZm9ybScpLmxhc3QoKS5maW5kKCcuc2VsZWN0MicpLnNlbGVjdDIoe1xuICAgICAgICAgICAgcGxhY2Vob2xkZXI6ICdTZWxlY3QgYW4gb3B0aW9uJyxcbiAgICAgICAgICAgIGFsbG93Q2xlYXI6IHRydWUsXG4gICAgICAgIH0pO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KVxuICAgICAgICAgICAgLnByZXYoKVxuICAgICAgICAgICAgLmZpbmQoJy5tdWx0aS1mb3JtJylcbiAgICAgICAgICAgIC5sYXN0KClcbiAgICAgICAgICAgIC5maW5kKCcuYWRkX3RvX2NvbGxlY3Rpb24nKVxuICAgICAgICAgICAgLmF0dHIoJ3BhcmVudF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgdGhpcy5hZGRXcmFwcGVyT25BZGQodGFyZ2V0KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuYXR0cigncGFyZW50X2NvdW50JywgY291bnQpO1xuICAgICAgICBkeW5hbWljRmllbGQuaHVtYW5pdGFyaWFuU2NvcGVIaWRlVm9jYWJ1bGFyeVVyaSgpO1xuICAgICAgICBkeW5hbWljRmllbGQuY291bnRyeUJ1ZGdldEhpZGVDb2RlRmllbGQoKTtcbiAgICAgICAgZHluYW1pY0ZpZWxkLnNlY3RvclZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgZHluYW1pY0ZpZWxkLnJlY2lwaWVudFZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgZHluYW1pY0ZpZWxkLnBvbGljeVZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgZHluYW1pY0ZpZWxkLnRhZ1ZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgZHluYW1pY0ZpZWxkLnRyYW5zYWN0aW9uQWlkVHlwZVZvY2FidWxhcnlIaWRlRmllbGQoKTtcbiAgICAgICAgZHluYW1pY0ZpZWxkLmluZGljYXRvclJlZmVyZW5jZUhpZGVGaWVsZFVyaSgpO1xuICAgIH1cbiAgICAvLyBkZWxldGVzIGNvbGxlY3Rpb25cbiAgICBkZWxldGVGb3JtKGV2KSB7XG4gICAgICAgIGV2LnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIGNvbnN0IHRhcmdldCA9IGV2LnRhcmdldDtcbiAgICAgICAgY29uc3QgY29sbGVjdGlvbkxlbmd0aCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLm11bHRpLWZvcm0nKS5sZW5ndGhcbiAgICAgICAgICAgID8gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuY2xvc2VzdCgnLnN1YmVsZW1lbnQnKS5maW5kKCcuZm9ybS1jaGlsZC1ib2R5JykubGVuZ3RoXG4gICAgICAgICAgICA6ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmZvcm0tY2hpbGQtYm9keScpLmxlbmd0aDtcbiAgICAgICAgY29uc3QgY291bnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5hZGRfdG9fY29sbGVjdGlvbicpLmF0dHIoJ2NoaWxkX2NvdW50JylcbiAgICAgICAgICAgID8gcGFyc2VJbnQoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX2NvbGxlY3Rpb24nKS5hdHRyKCdjaGlsZF9jb3VudCcpKSArIDFcbiAgICAgICAgICAgIDogY29sbGVjdGlvbkxlbmd0aDtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX2NvbGxlY3Rpb24nKS5hdHRyKCdjaGlsZF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgaWYgKGNvbGxlY3Rpb25MZW5ndGggPiAxKSB7XG4gICAgICAgICAgICBjb25zdCB0ZyA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpLmNsb3Nlc3QoJy5mb3JtLWNoaWxkLWJvZHknKTtcbiAgICAgICAgICAgIHRnLm5leHQoJy5lcnJvcicpLnJlbW92ZSgpO1xuICAgICAgICAgICAgdGcucmVtb3ZlKCk7XG4gICAgICAgIH1cbiAgICB9XG4gICAgLy8gZGVsZXRlcyBwYXJlbnQgY29sbGVjdGlvblxuICAgIGRlbGV0ZVBhcmVudEZvcm0oZXYpIHtcbiAgICAgICAgZXYucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgY29uc3QgdGFyZ2V0ID0gZXYudGFyZ2V0O1xuICAgICAgICBjb25zdCBjb2xsZWN0aW9uTGVuZ3RoID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuc3ViZWxlbWVudCcpLmxlbmd0aDtcbiAgICAgICAgY29uc3QgY291bnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5hZGRfdG9fcGFyZW50JykuYXR0cignY2hpbGRfY291bnQnKVxuICAgICAgICAgICAgPyBwYXJzZUludCgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5hZGRfdG9fcGFyZW50JykuYXR0cignY2hpbGRfY291bnQnKSkgKyAxXG4gICAgICAgICAgICA6IGNvbGxlY3Rpb25MZW5ndGg7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmFkZF90b19wYXJlbnQnKS5hdHRyKCdjaGlsZF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuYWRkX3RvX3BhcmVudCcpLmF0dHIoJ3BhcmVudF9jb3VudCcsIGNvdW50KTtcbiAgICAgICAgaWYgKGNvbGxlY3Rpb25MZW5ndGggPiAyKSB7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGFyZ2V0KS5wYXJlbnQoKS5yZW1vdmUoKTtcbiAgICAgICAgfVxuICAgIH1cbiAgICAvL2FkZCB3cmFwcGVyIGRpdiBhcm91bmQgdGhlIGF0dHJpYnV0ZXNcbiAgICBhZGRXcmFwcGVyKCkge1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5tdWx0aS1mb3JtJykuZWFjaChmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcbiAgICAgICAgICAgICAgICAuZmluZCgnLmF0dHJpYnV0ZScpXG4gICAgICAgICAgICAgICAgLndyYXBBbGwoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCc8ZGl2IGNsYXNzPVwiZm9ybS1maWVsZC1ncm91cCBmbGV4IGZsZXgtd3JhcCBhdHRyaWJ1dGUtd3JhcHBlciBtYi00XCI+PC9kaXY+JykpO1xuICAgICAgICB9KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuc3ViZWxlbWVudCcpXG4gICAgICAgICAgICAuZmluZCgnLndyYXBwZWQtY2hpbGQtYm9keScpXG4gICAgICAgICAgICAuZWFjaChmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcbiAgICAgICAgICAgICAgICAuZmluZCgnLnN1Yi1hdHRyaWJ1dGUnKVxuICAgICAgICAgICAgICAgIC53cmFwQWxsKCgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnPGRpdiBjbGFzcz1cImZvcm0tZmllbGQtZ3JvdXAgZmxleCBmbGV4LXdyYXAgc3ViLWF0dHJpYnV0ZS13cmFwcGVyIG1iLTRcIj48L2Rpdj4nKSk7XG4gICAgICAgIH0pO1xuICAgICAgICBjb25zdCBmb3JtRmllbGQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2Zvcm0+LmZvcm0tZmllbGQnKTtcbiAgICAgICAgaWYgKGZvcm1GaWVsZC5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBmb3JtRmllbGQud3JhcEFsbCgnPGRpdiBjbGFzcz1cImZvcm0tZmllbGQtZ3JvdXAtb3V0ZXIgZ3JpZCB4bDpncmlkLWNvbHMtMiBtYi02IC1teC0zIGdhcC15LTZcIj48L2Rpdj4nKTtcbiAgICAgICAgfVxuICAgIH1cbiAgICBhZGRXcmFwcGVyT25BZGQodGFyZ2V0KSB7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXG4gICAgICAgICAgICAucHJldigpXG4gICAgICAgICAgICAuZmluZCgnLm11bHRpLWZvcm0nKVxuICAgICAgICAgICAgLmxhc3QoKVxuICAgICAgICAgICAgLmZpbmQoJy5hdHRyaWJ1dGUnKVxuICAgICAgICAgICAgLndyYXBBbGwoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCc8ZGl2IGNsYXNzPVwiZm9ybS1maWVsZC1ncm91cCBncmlkIHhsOmdyaWQtY29scy0yIGF0dHJpYnV0ZS13cmFwcGVyIG1iLTRcIj48L2Rpdj4nKSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0YXJnZXQpXG4gICAgICAgICAgICAucHJldigpXG4gICAgICAgICAgICAuZmluZCgnLm11bHRpLWZvcm0nKVxuICAgICAgICAgICAgLmxhc3QoKVxuICAgICAgICAgICAgLmZpbmQoJy5zdWJlbGVtZW50JylcbiAgICAgICAgICAgIC5maW5kKCcud3JhcHBlZC1jaGlsZC1ib2R5JylcbiAgICAgICAgICAgIC5lYWNoKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKVxuICAgICAgICAgICAgICAgIC5maW5kKCcuc3ViLWF0dHJpYnV0ZScpXG4gICAgICAgICAgICAgICAgLndyYXBBbGwoKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCc8ZGl2IGNsYXNzPVwiZm9ybS1maWVsZC1ncm91cCBmbGV4IGZsZXgtd3JhcCBzdWItYXR0cmlidXRlLXdyYXBwZXIgbWItNFwiPjwvZGl2PicpKTtcbiAgICAgICAgfSk7XG4gICAgfVxuICAgIHRleHRBcmVhSGVpZ2h0KGV2KSB7XG4gICAgICAgIGNvbnN0IHRhcmdldCA9IGV2LnRhcmdldDtcbiAgICAgICAgY29uc3QgaGVpZ2h0ID0gdGFyZ2V0LnNjcm9sbEhlaWdodDtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRhcmdldCkuY3NzKCdoZWlnaHQnLCBoZWlnaHQpO1xuICAgIH1cbiAgICBhZGRUb0NvbGxlY3Rpb24oKSB7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsICcuYWRkX3RvX2NvbGxlY3Rpb24nLCAoZXZlbnQpID0+IHtcbiAgICAgICAgICAgIGlmICgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoZXZlbnQudGFyZ2V0KS5oYXNDbGFzcygnYWRkLWljb24nKSkge1xuICAgICAgICAgICAgICAgIGV2ZW50LnN0b3BQcm9wYWdhdGlvbigpO1xuICAgICAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShldmVudC50YXJnZXQpXG4gICAgICAgICAgICAgICAgICAgIC5wYXJlbnQoJ2J1dHRvbicpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjbGljaycpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZWxzZSB7XG4gICAgICAgICAgICAgICAgdGhpcy5hZGRGb3JtKGV2ZW50KTtcbiAgICAgICAgICAgICAgICB0aGlzLmhhbmRsZURlbGV0ZVBhcmVudEJ1dHRvbnMoKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmFkZF90b19wYXJlbnQnKS5vbignY2xpY2snLCAoZXZlbnQpID0+IHtcbiAgICAgICAgICAgIGlmICgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoZXZlbnQudGFyZ2V0KS5oYXNDbGFzcygnYWRkLWljb24nKSkge1xuICAgICAgICAgICAgICAgIGV2ZW50LnN0b3BQcm9wYWdhdGlvbigpO1xuICAgICAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShldmVudC50YXJnZXQpXG4gICAgICAgICAgICAgICAgICAgIC5wYXJlbnQoJ2J1dHRvbicpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjbGljaycpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZWxzZSB7XG4gICAgICAgICAgICAgICAgdGhpcy5hZGRQYXJlbnRGb3JtKGV2ZW50KTtcbiAgICAgICAgICAgICAgICB0aGlzLmhhbmRsZURlbGV0ZVBhcmVudEJ1dHRvbnMoKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSk7XG4gICAgfVxuICAgIGRlbGV0ZUNvbGxlY3Rpb24oKSB7XG4gICAgICAgIGNvbnN0IGRlbGV0ZUNvbmZpcm1hdGlvbiA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmRlbGV0ZS1jb25maXJtYXRpb24nKSwgY2FuY2VsUG9wdXAgPSAnLmNhbmNlbC1wb3B1cCcsIGRlbGV0ZUNvbmZpcm0gPSAnLmRlbGV0ZS1jb25maXJtJztcbiAgICAgICAgbGV0IGRlbGV0ZUluZGV4ID0ge30sIGNoaWxkT3JQYXJlbnQgPSAnJztcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgJy5kZWxldGUnLCAoZXZlbnQpID0+IHtcbiAgICAgICAgICAgIGRlbGV0ZUNvbmZpcm1hdGlvbi5mYWRlSW4oKTtcbiAgICAgICAgICAgIGRlbGV0ZUluZGV4ID0gZXZlbnQ7XG4gICAgICAgICAgICBjaGlsZE9yUGFyZW50ID0gJ2NoaWxkJztcbiAgICAgICAgfSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsIGNhbmNlbFBvcHVwLCAoKSA9PiB7XG4gICAgICAgICAgICBkZWxldGVDb25maXJtYXRpb24uZmFkZU91dCgpO1xuICAgICAgICAgICAgZGVsZXRlSW5kZXggPSB7fTtcbiAgICAgICAgICAgIGNoaWxkT3JQYXJlbnQgPSAnJztcbiAgICAgICAgfSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsIGRlbGV0ZUNvbmZpcm0sICgpID0+IHtcbiAgICAgICAgICAgIGlmIChjaGlsZE9yUGFyZW50ID09PSAnY2hpbGQnKSB7XG4gICAgICAgICAgICAgICAgdGhpcy5kZWxldGVGb3JtKGRlbGV0ZUluZGV4KTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2UgaWYgKGNoaWxkT3JQYXJlbnQgPT09ICdwYXJlbnQnKSB7XG4gICAgICAgICAgICAgICAgdGhpcy5kZWxldGVQYXJlbnRGb3JtKGRlbGV0ZUluZGV4KTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGRlbGV0ZUNvbmZpcm1hdGlvbi5mYWRlT3V0KCk7XG4gICAgICAgICAgICBkZWxldGVJbmRleCA9IHt9O1xuICAgICAgICAgICAgY2hpbGRPclBhcmVudCA9ICcnO1xuICAgICAgICB9KTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ21vdXNlZW50ZXInLCAnLmRlbGV0ZS1wYXJlbnQnLCAoZXZlbnQpID0+IHtcbiAgICAgICAgICAgIC8vIGVzbGludC1kaXNhYmxlLW5leHQtbGluZSBAdHlwZXNjcmlwdC1lc2xpbnQvYmFuLXRzLWNvbW1lbnRcbiAgICAgICAgICAgIC8vQHRzLWlnbm9yZVxuICAgICAgICAgICAgY29uc3QgZGVsZXRlQnV0dG9uID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGV2ZW50LnRhcmdldCk7XG4gICAgICAgICAgICAvLyBlc2xpbnQtZGlzYWJsZS1uZXh0LWxpbmUgQHR5cGVzY3JpcHQtZXNsaW50L2Jhbi10cy1jb21tZW50XG4gICAgICAgICAgICAvL0B0cy1pZ25vcmVcbiAgICAgICAgICAgIGNvbnN0IG11bHRpRm9ybSA9IGRlbGV0ZUJ1dHRvbi5jbG9zZXN0KCcubXVsdGktZm9ybSwgLndyYXBwZWQtY2hpbGQtYm9keScpO1xuICAgICAgICAgICAgbXVsdGlGb3JtLmNzcyh7XG4gICAgICAgICAgICAgICAgYmFja2dyb3VuZDogJyNGRkY4RjcnLFxuICAgICAgICAgICAgICAgIG91dGxpbmU6ICcycHggc29saWQgI0YxOUJBMCcsXG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdtb3VzZWxlYXZlJywgJy5kZWxldGUtcGFyZW50JywgKGV2ZW50KSA9PiB7XG4gICAgICAgICAgICAvLyBlc2xpbnQtZGlzYWJsZS1uZXh0LWxpbmUgQHR5cGVzY3JpcHQtZXNsaW50L2Jhbi10cy1jb21tZW50XG4gICAgICAgICAgICAvL0B0cy1pZ25vcmVcbiAgICAgICAgICAgIGNvbnN0IGRlbGV0ZUJ1dHRvbiA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShldmVudC50YXJnZXQpO1xuICAgICAgICAgICAgLy8gZXNsaW50LWRpc2FibGUtbmV4dC1saW5lIEB0eXBlc2NyaXB0LWVzbGludC9iYW4tdHMtY29tbWVudFxuICAgICAgICAgICAgLy9AdHMtaWdub3JlXG4gICAgICAgICAgICBjb25zdCBtdWx0aUZvcm0gPSBkZWxldGVCdXR0b24uY2xvc2VzdCgnLm11bHRpLWZvcm0sIC53cmFwcGVkLWNoaWxkLWJvZHknKTtcbiAgICAgICAgICAgIG11bHRpRm9ybS5jc3Moe1xuICAgICAgICAgICAgICAgIGJhY2tncm91bmQ6ICcnLFxuICAgICAgICAgICAgICAgIG91dGxpbmU6ICcnLFxuICAgICAgICAgICAgfSk7XG4gICAgICAgIH0pO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCAnLmRlbGV0ZS1wYXJlbnQnLCAoZXZlbnQpID0+IHtcbiAgICAgICAgICAgIGRlbGV0ZUNvbmZpcm1hdGlvbi5mYWRlSW4oKTtcbiAgICAgICAgICAgIGRlbGV0ZUluZGV4ID0gZXZlbnQ7XG4gICAgICAgICAgICBjaGlsZE9yUGFyZW50ID0gJ3BhcmVudCc7XG4gICAgICAgIH0pO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5zZWxlY3QyJykuc2VsZWN0Mih7XG4gICAgICAgICAgICBwbGFjZWhvbGRlcjogJ1NlbGVjdCBhbiBvcHRpb24nLFxuICAgICAgICAgICAgYWxsb3dDbGVhcjogdHJ1ZSxcbiAgICAgICAgfSk7XG4gICAgICAgIC8vIHVwZGF0ZSBmb3JtYXQgb24gY2hhbmdlIG9mIGRvY3VtZW50IGxpbmtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NoYW5nZScsICdpbnB1dFtpZCo9XCJbdXJsXVwiXScsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgIGNvbnN0IGZpbGVQYXRoID0gKChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJycpLnRvU3RyaW5nKCk7XG4gICAgICAgICAgICBjb25zdCBkb2N1bWVudCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKVxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgLmZpbmQoJ2lucHV0W2lkKj1cIltkb2N1bWVudF1cIl0nKVxuICAgICAgICAgICAgICAgIC52YWwoKTtcbiAgICAgICAgICAgIGNvbnN0IHVybCA9IGAvbWltZXR5cGU/dXJsPSR7ZmlsZVBhdGh9JnR5cGU9dXJsYDtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS5jbG9zZXN0KCcuZm9ybS1maWVsZCcpLmZpbmQoJy50ZXh0LWRhbmdlcicpLnJlbW92ZSgpO1xuICAgICAgICAgICAgaWYgKGZpbGVQYXRoICE9PSAnJykge1xuICAgICAgICAgICAgICAgIGF4aW9zXzEuZGVmYXVsdC5nZXQodXJsKS50aGVuKChyZXNwb25zZSkgPT4ge1xuICAgICAgICAgICAgICAgICAgICBpZiAocmVzcG9uc2UuZGF0YS5zdWNjZXNzKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICBjb25zdCBmb3JtYXQgPSByZXNwb25zZS5kYXRhLmRhdGEubWltZXR5cGU7XG4gICAgICAgICAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC5maW5kKCdzZWxlY3RbaWQqPVwiW2Zvcm1hdF1cIl0nKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC52YWwoZm9ybWF0KVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS5jbG9zZXN0KCcuZm9ybS1maWVsZCcpLmZpbmQoJy50ZXh0LWRhbmdlcicpLnJlbW92ZSgpO1xuICAgICAgICAgICAgICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkJylcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAuYXBwZW5kKFwiPGRpdiBjbGFzcz0ndGV4dC1kYW5nZXIgZXJyb3InPlwiICtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICByZXNwb25zZS5kYXRhLm1lc3NhZ2UgK1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICc8L2Rpdj4nKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLmZpbmQoJ3NlbGVjdFtpZCo9XCJbZm9ybWF0XVwiXScpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJyk7XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpXG4gICAgICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAgICAgLmZpbmQoJ2lucHV0W2lkKj1cIltkb2N1bWVudF1cIl0nKVxuICAgICAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKTtcbiAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2UgaWYgKCFkb2N1bWVudCB8fCBkb2N1bWVudCA9PT0gJycpIHtcbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoJ3NlbGVjdFtpZCo9XCJbZm9ybWF0XVwiXScpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjaGFuZ2UnLCAnaW5wdXRbaWQqPVwiW2RvY3VtZW50XVwiXScsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgIGNvbnN0IGZpbGVQYXRoID0gKChfYSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJycpLnRvU3RyaW5nKCk7XG4gICAgICAgICAgICBjb25zdCB1cmwgPSBgL21pbWV0eXBlP3VybD0ke2ZpbGVQYXRofSYmdHlwZT1kb2N1bWVudGA7XG4gICAgICAgICAgICBjb25zdCBmaWxlVXJsID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpXG4gICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAuZmluZCgnaW5wdXRbaWQqPVwiW3VybF1cIl0nKVxuICAgICAgICAgICAgICAgIC52YWwoKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS5jbG9zZXN0KCcuZm9ybS1maWVsZCcpLmZpbmQoJy50ZXh0LWRhbmdlcicpLnJlbW92ZSgpO1xuICAgICAgICAgICAgaWYgKGZpbGVQYXRoICE9PSAnJykge1xuICAgICAgICAgICAgICAgIGF4aW9zXzEuZGVmYXVsdC5nZXQodXJsKS50aGVuKChyZXNwb25zZSkgPT4ge1xuICAgICAgICAgICAgICAgICAgICBpZiAocmVzcG9uc2UuZGF0YS5zdWNjZXNzKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICBjb25zdCBmb3JtYXQgPSByZXNwb25zZS5kYXRhLmRhdGEubWltZXR5cGU7XG4gICAgICAgICAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAuY2xvc2VzdCgnLmZvcm0tZmllbGQtZ3JvdXAnKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC5maW5kKCdzZWxlY3RbaWQqPVwiW2Zvcm1hdF1cIl0nKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC52YWwoZm9ybWF0KVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC5jbG9zZXN0KCcuZm9ybS1maWVsZC1ncm91cCcpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLmZpbmQoJ3NlbGVjdFtpZCo9XCJbZm9ybWF0XVwiXScpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJyk7XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoJ2lucHV0W2lkKj1cIlt1cmxdXCJdJylcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZWxzZSBpZiAoIWZpbGVVcmwgfHwgZmlsZVVybCA9PT0gJycpIHtcbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcylcbiAgICAgICAgICAgICAgICAgICAgLmNsb3Nlc3QoJy5mb3JtLWZpZWxkLWdyb3VwJylcbiAgICAgICAgICAgICAgICAgICAgLmZpbmQoJ3NlbGVjdFtpZCo9XCJbZm9ybWF0XVwiXScpXG4gICAgICAgICAgICAgICAgICAgIC52YWwoJycpXG4gICAgICAgICAgICAgICAgICAgIC50cmlnZ2VyKCdjaGFuZ2UnKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSk7XG4gICAgfVxuICAgIGhhbmRsZURlbGV0ZVBhcmVudEJ1dHRvbnMoKSB7XG4gICAgICAgIGNvbnN0IGRlbGV0ZUJ1dHRvbnMgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuZGVsZXRlLXBhcmVudC1zZWxlY3RvcicpO1xuICAgICAgICBjb25zdCBjaGFuZ2VEZWxldGVCdXR0b25Jbm5lckh0bWwgPSAoYnV0dG9uKSA9PiB7XG4gICAgICAgICAgICBjb25zdCBpbml0aWFsVGV4dCA9IGVzY2FwZUh0bWwoYnV0dG9uLnRleHRDb250ZW50KTtcbiAgICAgICAgICAgIGJ1dHRvbi5pbm5lckhUTUwgPSBgXG4gICAgICAgICA8c3ZnIGNsYXNzPVwidGV4dC1bMXJlbV0gbWItMC41XCIgdmlld0JveD1cIjAgMCAxNiAxNlwiIGZpbGw9XCJub25lXCIgeG1sbnM9XCJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2Z1wiPlxuICAgICAgICAgICA8cGF0aCBkPVwiTTYuNjY2NjcgMTJDNi44NDM0OCAxMiA3LjAxMzA1IDExLjkyOTggNy4xMzgwNyAxMS44MDQ3QzcuMjYzMSAxMS42Nzk3IDcuMzMzMzMgMTEuNTEwMSA3LjMzMzMzIDExLjMzMzNWNy4zMzMzNEM3LjMzMzMzIDcuMTU2NTMgNy4yNjMxIDYuOTg2OTYgNy4xMzgwNyA2Ljg2MTkzQzcuMDEzMDUgNi43MzY5MSA2Ljg0MzQ4IDYuNjY2NjcgNi42NjY2NyA2LjY2NjY3QzYuNDg5ODYgNi42NjY2NyA2LjMyMDI5IDYuNzM2OTEgNi4xOTUyNiA2Ljg2MTkzQzYuMDcwMjQgNi45ODY5NiA2IDcuMTU2NTMgNiA3LjMzMzM0VjExLjMzMzNDNiAxMS41MTAxIDYuMDcwMjQgMTEuNjc5NyA2LjE5NTI2IDExLjgwNDdDNi4zMjAyOSAxMS45Mjk4IDYuNDg5ODYgMTIgNi42NjY2NyAxMlpNMTMuMzMzMyA0SDEwLjY2NjdWMy4zMzMzNEMxMC42NjY3IDIuODAyOSAxMC40NTYgMi4yOTQyIDEwLjA4MDkgMS45MTkxMkM5LjcwNTgxIDEuNTQ0MDUgOS4xOTcxIDEuMzMzMzQgOC42NjY2NyAxLjMzMzM0SDcuMzMzMzNDNi44MDI5IDEuMzMzMzQgNi4yOTQxOSAxLjU0NDA1IDUuOTE5MTIgMS45MTkxMkM1LjU0NDA1IDIuMjk0MiA1LjMzMzMzIDIuODAyOSA1LjMzMzMzIDMuMzMzMzRWNEgyLjY2NjY3QzIuNDg5ODYgNCAyLjMyMDI5IDQuMDcwMjQgMi4xOTUyNiA0LjE5NTI2QzIuMDcwMjQgNC4zMjAyOSAyIDQuNDg5ODYgMiA0LjY2NjY3QzIgNC44NDM0OCAyLjA3MDI0IDUuMDEzMDUgMi4xOTUyNiA1LjEzODA3QzIuMzIwMjkgNS4yNjMxIDIuNDg5ODYgNS4zMzMzNCAyLjY2NjY3IDUuMzMzMzRIMy4zMzMzM1YxMi42NjY3QzMuMzMzMzMgMTMuMTk3MSAzLjU0NDA1IDEzLjcwNTggMy45MTkxMiAxNC4wODA5QzQuMjk0MTkgMTQuNDU2IDQuODAyOSAxNC42NjY3IDUuMzMzMzMgMTQuNjY2N0gxMC42NjY3QzExLjE5NzEgMTQuNjY2NyAxMS43MDU4IDE0LjQ1NiAxMi4wODA5IDE0LjA4MDlDMTIuNDU2IDEzLjcwNTggMTIuNjY2NyAxMy4xOTcxIDEyLjY2NjcgMTIuNjY2N1Y1LjMzMzM0SDEzLjMzMzNDMTMuNTEwMSA1LjMzMzM0IDEzLjY3OTcgNS4yNjMxIDEzLjgwNDcgNS4xMzgwN0MxMy45Mjk4IDUuMDEzMDUgMTQgNC44NDM0OCAxNCA0LjY2NjY3QzE0IDQuNDg5ODYgMTMuOTI5OCA0LjMyMDI5IDEzLjgwNDcgNC4xOTUyNkMxMy42Nzk3IDQuMDcwMjQgMTMuNTEwMSA0IDEzLjMzMzMgNFpNNi42NjY2NyAzLjMzMzM0QzYuNjY2NjcgMy4xNTY1MiA2LjczNjkgMi45ODY5NiA2Ljg2MTkzIDIuODYxOTNDNi45ODY5NSAyLjczNjkxIDcuMTU2NTIgMi42NjY2NyA3LjMzMzMzIDIuNjY2NjdIOC42NjY2N0M4Ljg0MzQ4IDIuNjY2NjcgOS4wMTMwNSAyLjczNjkxIDkuMTM4MDcgMi44NjE5M0M5LjI2MzEgMi45ODY5NiA5LjMzMzMzIDMuMTU2NTIgOS4zMzMzMyAzLjMzMzM0VjRINi42NjY2N1YzLjMzMzM0Wk0xMS4zMzMzIDEyLjY2NjdDMTEuMzMzMyAxMi44NDM1IDExLjI2MzEgMTMuMDEzMSAxMS4xMzgxIDEzLjEzODFDMTEuMDEzIDEzLjI2MzEgMTAuODQzNSAxMy4zMzMzIDEwLjY2NjcgMTMuMzMzM0g1LjMzMzMzQzUuMTU2NTIgMTMuMzMzMyA0Ljk4Njk1IDEzLjI2MzEgNC44NjE5MyAxMy4xMzgxQzQuNzM2OSAxMy4wMTMxIDQuNjY2NjcgMTIuODQzNSA0LjY2NjY3IDEyLjY2NjdWNS4zMzMzNEgxMS4zMzMzVjEyLjY2NjdaTTkuMzMzMzMgMTJDOS41MTAxNCAxMiA5LjY3OTcxIDExLjkyOTggOS44MDQ3NCAxMS44MDQ3QzkuOTI5NzYgMTEuNjc5NyAxMCAxMS41MTAxIDEwIDExLjMzMzNWNy4zMzMzNEMxMCA3LjE1NjUzIDkuOTI5NzYgNi45ODY5NiA5LjgwNDc0IDYuODYxOTNDOS42Nzk3MSA2LjczNjkxIDkuNTEwMTQgNi42NjY2NyA5LjMzMzMzIDYuNjY2NjdDOS4xNTY1MiA2LjY2NjY3IDguOTg2OTUgNi43MzY5MSA4Ljg2MTkzIDYuODYxOTNDOC43MzY5MSA2Ljk4Njk2IDguNjY2NjcgNy4xNTY1MyA4LjY2NjY3IDcuMzMzMzRWMTEuMzMzM0M4LjY2NjY3IDExLjUxMDEgOC43MzY5MSAxMS42Nzk3IDguODYxOTMgMTEuODA0N0M4Ljk4Njk1IDExLjkyOTggOS4xNTY1MiAxMiA5LjMzMzMzIDEyWlwiIGZpbGw9XCIjRTM0RDVCXCIvPlxuICAgICAgICAgPC9zdmc+XG4gICAgICAgICAke2luaXRpYWxUZXh0fVxuICAgICAgYDtcbiAgICAgICAgfTtcbiAgICAgICAgZGVsZXRlQnV0dG9ucy5mb3JFYWNoKChidXR0b24pID0+IHtcbiAgICAgICAgICAgIGNoYW5nZURlbGV0ZUJ1dHRvbklubmVySHRtbChidXR0b24pO1xuICAgICAgICB9KTtcbiAgICB9XG59XG4oMCwganF1ZXJ5XzEuZGVmYXVsdCkoZnVuY3Rpb24gKCkge1xuICAgIGNvbnN0IGZvcm1CdWlsZGVyID0gbmV3IEZvcm1CdWlsZGVyKCk7XG4gICAgZm9ybUJ1aWxkZXIuYWRkV3JhcHBlcigpO1xuICAgIGR5bmFtaWNGaWVsZC5oaWRlU2hvd0Zvcm1GaWVsZHMoKTtcbiAgICBkeW5hbWljRmllbGQudXBkYXRlQWN0aXZpdHlJZGVudGlmaWVyKCk7XG4gICAgZm9ybUJ1aWxkZXIuYWRkVG9Db2xsZWN0aW9uKCk7XG4gICAgZm9ybUJ1aWxkZXIuZGVsZXRlQ29sbGVjdGlvbigpO1xuICAgIC8qKlxuICAgICAqIFRleHQgYXJlYSBoZWlnaHQgb24gdHlwaW5nXG4gICAgICovXG4gICAgY29uc3QgdGV4dEFyZWFUYXJnZXQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ3RleHRhcmVhLmZvcm1fX2lucHV0Jyk7XG4gICAgaWYgKHRleHRBcmVhVGFyZ2V0Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2lucHV0JywgJ3RleHRhcmVhLmZvcm1fX2lucHV0JywgKGV2ZW50KSA9PiB7XG4gICAgICAgICAgICBmb3JtQnVpbGRlci50ZXh0QXJlYUhlaWdodChldmVudCk7XG4gICAgICAgIH0pO1xuICAgIH1cbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignc2VsZWN0MjpvcGVuJywgJy5zZWxlY3QyJywgKCkgPT4ge1xuICAgICAgICBjb25zdCBzZWxlY3Rfc2VhcmNoID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLnNlbGVjdDItc2VhcmNoX19maWVsZCcpO1xuICAgICAgICBpZiAoc2VsZWN0X3NlYXJjaCkge1xuICAgICAgICAgICAgc2VsZWN0X3NlYXJjaC5mb2N1cygpO1xuICAgICAgICB9XG4gICAgfSk7XG4gICAgLyoqXG4gICAgICogY2hlY2tzIHJlZ2lzdHJhdGlvbiBhZ2VuY3ksIGNvdW50cnkgYW5kIHJlZ2lzdHJhdGlvbiBudW1iZXIgdG8gZGVkdWNlIGlkZW50aWZpZXJcbiAgICAgKi9cbiAgICB1cGRhdGVSZWdpc3RyYXRpb25BZ2VuY3koKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjb3JnYW5pemF0aW9uX2NvdW50cnknKSk7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjb3JnYW5pc2F0aW9uX2lkZW50aWZpZXInKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpO1xuICAgIGZ1bmN0aW9uIHVwZGF0ZVJlZ2lzdHJhdGlvbkFnZW5jeShjb3VudHJ5KSB7XG4gICAgICAgIGNvbnN0IGVuZHBvaW50ID0gY291bnRyeS52YWwoKVxuICAgICAgICAgICAgPyAnL29yZ2FuaXNhdGlvbi9hZ2VuY3kvJyArIGNvdW50cnkudmFsKClcbiAgICAgICAgICAgIDogJy9vcmdhbmlzYXRpb24vYWdlbmN5Lyc7XG4gICAgICAgIGpxdWVyeV8xLmRlZmF1bHQuYWpheCh7IHVybDogZW5kcG9pbnQgfSkudGhlbigocmVzcG9uc2UpID0+IHtcbiAgICAgICAgICAgIHZhciBfYTtcbiAgICAgICAgICAgIGNvbnN0IGN1cnJlbnRfdmFsID0gKF9hID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjb3JnYW5pemF0aW9uX3JlZ2lzdHJhdGlvbl9hZ2VuY3knKS52YWwoKSkgIT09IG51bGwgJiYgX2EgIT09IHZvaWQgMCA/IF9hIDogJyc7XG4gICAgICAgICAgICBsZXQgdmFsID0gZmFsc2U7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScpLmVtcHR5KCk7XG4gICAgICAgICAgICBmb3IgKGNvbnN0IGRhdGEgaW4gcmVzcG9uc2UuZGF0YSkge1xuICAgICAgICAgICAgICAgIGlmIChkYXRhID09PSBjdXJyZW50X3ZhbCkge1xuICAgICAgICAgICAgICAgICAgICB2YWwgPSB0cnVlO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScpXG4gICAgICAgICAgICAgICAgICAgIC5hcHBlbmQobmV3IE9wdGlvbihyZXNwb25zZS5kYXRhW2RhdGFdLCBkYXRhLCB0cnVlLCB0cnVlKSlcbiAgICAgICAgICAgICAgICAgICAgLnZhbCgnJylcbiAgICAgICAgICAgICAgICAgICAgLnRyaWdnZXIoJ2NoYW5nZScpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjb3JnYW5pemF0aW9uX3JlZ2lzdHJhdGlvbl9hZ2VuY3knKVxuICAgICAgICAgICAgICAgIC52YWwodmFsID8gY3VycmVudF92YWwgOiAnJylcbiAgICAgICAgICAgICAgICAudHJpZ2dlcignY2hhbmdlJyk7XG4gICAgICAgIH0pO1xuICAgIH1cbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignc2VsZWN0MjpzZWxlY3QnLCAnI29yZ2FuaXphdGlvbl9jb3VudHJ5JywgZnVuY3Rpb24gKCkge1xuICAgICAgICB1cGRhdGVSZWdpc3RyYXRpb25BZ2VuY3koKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpKTtcbiAgICB9KTtcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignc2VsZWN0MjpjbGVhcicsICcjb3JnYW5pemF0aW9uX2NvdW50cnknLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHVwZGF0ZVJlZ2lzdHJhdGlvbkFnZW5jeSgoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykpO1xuICAgIH0pO1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdzZWxlY3QyOnNlbGVjdCcsICcjb3JnYW5pemF0aW9uX3JlZ2lzdHJhdGlvbl9hZ2VuY3knLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgIGNvbnN0IGlkZW50aWZpZXIgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykudmFsKCkgKyAnLScgKyAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNyZWdpc3RyYXRpb25fbnVtYmVyJykudmFsKCk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI29yZ2FuaXNhdGlvbl9pZGVudGlmaWVyJykudmFsKGlkZW50aWZpZXIpO1xuICAgIH0pO1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdzZWxlY3QyOmNsZWFyJywgJyNvcmdhbml6YXRpb25fcmVnaXN0cmF0aW9uX2FnZW5jeScsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgY29uc3QgaWRlbnRpZmllciA9ICctJyArICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI3JlZ2lzdHJhdGlvbl9udW1iZXInKS52YWwoKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjb3JnYW5pc2F0aW9uX2lkZW50aWZpZXInKS52YWwoaWRlbnRpZmllcik7XG4gICAgfSk7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2tleXVwJywgJyNyZWdpc3RyYXRpb25fbnVtYmVyJywgZnVuY3Rpb24gKCkge1xuICAgICAgICBjb25zdCBpZGVudGlmaWVyID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjb3JnYW5pemF0aW9uX3JlZ2lzdHJhdGlvbl9hZ2VuY3knKS52YWwoKSArICctJyArICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS52YWwoKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjb3JnYW5pc2F0aW9uX2lkZW50aWZpZXInKS52YWwoaWRlbnRpZmllcik7XG4gICAgfSk7XG4gICAgLy8gYWRkIGNsYXNzIHRvIHRpdGxlIG9mIGNvbGxlY3Rpb24gd2hlbiB2YWxpZGF0aW9uIGVycm9yIG9jY3VycyBvbiBjb2xsZWN0aW9uIGxldmVsXG4gICAgY29uc3Qgc3ViZWxlbWVudCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJy5zdWJlbGVtZW50Jyk7XG4gICAgZm9yIChsZXQgaSA9IDA7IGkgPCBzdWJlbGVtZW50Lmxlbmd0aDsgaSsrKSB7XG4gICAgICAgIGNvbnN0IHRpdGxlID0gc3ViZWxlbWVudFtpXS5xdWVyeVNlbGVjdG9yKCcuY29udHJvbC1sYWJlbCcpO1xuICAgICAgICBjb25zdCBlcnJvckNvbnRhaW5lciA9IHN1YmVsZW1lbnRbaV0ucXVlcnlTZWxlY3RvcignLmNvbGxlY3Rpb25fZXJyb3InKTtcbiAgICAgICAgY29uc3QgY2hpbGRDb3VudCA9IGVycm9yQ29udGFpbmVyID09PSBudWxsIHx8IGVycm9yQ29udGFpbmVyID09PSB2b2lkIDAgPyB2b2lkIDAgOiBlcnJvckNvbnRhaW5lci5jaGlsZEVsZW1lbnRDb3VudDtcbiAgICAgICAgaWYgKGNoaWxkQ291bnQgJiYgY2hpbGRDb3VudCA+IDApIHtcbiAgICAgICAgICAgIHRpdGxlID09PSBudWxsIHx8IHRpdGxlID09PSB2b2lkIDAgPyB2b2lkIDAgOiB0aXRsZS5jbGFzc0xpc3QuYWRkKCdlcnJvci10aXRsZScpO1xuICAgICAgICB9XG4gICAgfVxuICAgIC8vIEFkZGluZyBjdXJzb3Igbm90IGFsbG93ZWQgdG8gPHNlbGVjdD4gd2hlcmUgZWxlbWVudEpzb25TY2hlbWEgcmVhZF9vbmx5IDogdHJ1ZVxuICAgIGNvbnN0IHJlYWRPbmx5U2VsZWN0cyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJ3NlbGVjdC5jdXJzb3Itbm90LWFsbG93ZWQnKTtcbiAgICBmb3IgKGxldCBpID0gMDsgaSA8IHJlYWRPbmx5U2VsZWN0cy5sZW5ndGg7IGkrKykge1xuICAgICAgICBjb25zdCBzZWxlY3QgPSByZWFkT25seVNlbGVjdHNbaV07XG4gICAgICAgIGNvbnN0IHNlbGVjdEVsZW1lbnRQYXJlbnRXcmFwcGVyID0gc2VsZWN0Lm5leHRTaWJsaW5nO1xuICAgICAgICBjb25zdCBzZWxlY3RFbGVtZW50UGFyZW50ID0gc2VsZWN0RWxlbWVudFBhcmVudFdyYXBwZXIgPT09IG51bGwgfHwgc2VsZWN0RWxlbWVudFBhcmVudFdyYXBwZXIgPT09IHZvaWQgMCA/IHZvaWQgMCA6IHNlbGVjdEVsZW1lbnRQYXJlbnRXcmFwcGVyLmZpcnN0Q2hpbGQ7XG4gICAgICAgIGNvbnN0IHNlbGVjdEVsZW1lbnQgPSBzZWxlY3RFbGVtZW50UGFyZW50ID09PSBudWxsIHx8IHNlbGVjdEVsZW1lbnRQYXJlbnQgPT09IHZvaWQgMCA/IHZvaWQgMCA6IHNlbGVjdEVsZW1lbnRQYXJlbnQuZmlyc3RDaGlsZDtcbiAgICAgICAgaWYgKHNlbGVjdEVsZW1lbnQpIHtcbiAgICAgICAgICAgIHNlbGVjdEVsZW1lbnQuc3R5bGUuY3Vyc29yID0gJ25vdC1hbGxvd2VkJztcbiAgICAgICAgfVxuICAgIH1cbiAgICBjb25zdCBkZWxldGVCdXR0b25zID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLmRlbGV0ZS1wYXJlbnQtc2VsZWN0b3InKTtcbiAgICBmdW5jdGlvbiBjaGFuZ2VEZWxldGVCdXR0b25Jbm5lckh0bWwoYnV0dG9uKSB7XG4gICAgICAgIGNvbnN0IGluaXRpYWxUZXh0ID0gZXNjYXBlSHRtbChidXR0b24udGV4dENvbnRlbnQpO1xuICAgICAgICBidXR0b24uaW5uZXJIVE1MID0gYFxuICAgICAgPHN2ZyB3aWR0aD1cIjE2XCIgaGVpZ2h0PVwiMTZcIiB2aWV3Qm94PVwiMCAwIDE2IDE2XCIgZmlsbD1cIm5vbmVcIiB4bWxucz1cImh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnXCI+XG4gICAgICAgIDxwYXRoIGQ9XCJNNi42NjY2NyAxMkM2Ljg0MzQ4IDEyIDcuMDEzMDUgMTEuOTI5OCA3LjEzODA3IDExLjgwNDdDNy4yNjMxIDExLjY3OTcgNy4zMzMzMyAxMS41MTAxIDcuMzMzMzMgMTEuMzMzM1Y3LjMzMzM0QzcuMzMzMzMgNy4xNTY1MyA3LjI2MzEgNi45ODY5NiA3LjEzODA3IDYuODYxOTNDNy4wMTMwNSA2LjczNjkxIDYuODQzNDggNi42NjY2NyA2LjY2NjY3IDYuNjY2NjdDNi40ODk4NiA2LjY2NjY3IDYuMzIwMjkgNi43MzY5MSA2LjE5NTI2IDYuODYxOTNDNi4wNzAyNCA2Ljk4Njk2IDYgNy4xNTY1MyA2IDcuMzMzMzRWMTEuMzMzM0M2IDExLjUxMDEgNi4wNzAyNCAxMS42Nzk3IDYuMTk1MjYgMTEuODA0N0M2LjMyMDI5IDExLjkyOTggNi40ODk4NiAxMiA2LjY2NjY3IDEyWk0xMy4zMzMzIDRIMTAuNjY2N1YzLjMzMzM0QzEwLjY2NjcgMi44MDI5IDEwLjQ1NiAyLjI5NDIgMTAuMDgwOSAxLjkxOTEyQzkuNzA1ODEgMS41NDQwNSA5LjE5NzEgMS4zMzMzNCA4LjY2NjY3IDEuMzMzMzRINy4zMzMzM0M2LjgwMjkgMS4zMzMzNCA2LjI5NDE5IDEuNTQ0MDUgNS45MTkxMiAxLjkxOTEyQzUuNTQ0MDUgMi4yOTQyIDUuMzMzMzMgMi44MDI5IDUuMzMzMzMgMy4zMzMzNFY0SDIuNjY2NjdDMi40ODk4NiA0IDIuMzIwMjkgNC4wNzAyNCAyLjE5NTI2IDQuMTk1MjZDMi4wNzAyNCA0LjMyMDI5IDIgNC40ODk4NiAyIDQuNjY2NjdDMiA0Ljg0MzQ4IDIuMDcwMjQgNS4wMTMwNSAyLjE5NTI2IDUuMTM4MDdDMi4zMjAyOSA1LjI2MzEgMi40ODk4NiA1LjMzMzM0IDIuNjY2NjcgNS4zMzMzNEgzLjMzMzMzVjEyLjY2NjdDMy4zMzMzMyAxMy4xOTcxIDMuNTQ0MDUgMTMuNzA1OCAzLjkxOTEyIDE0LjA4MDlDNC4yOTQxOSAxNC40NTYgNC44MDI5IDE0LjY2NjcgNS4zMzMzMyAxNC42NjY3SDEwLjY2NjdDMTEuMTk3MSAxNC42NjY3IDExLjcwNTggMTQuNDU2IDEyLjA4MDkgMTQuMDgwOUMxMi40NTYgMTMuNzA1OCAxMi42NjY3IDEzLjE5NzEgMTIuNjY2NyAxMi42NjY3VjUuMzMzMzRIMTMuMzMzM0MxMy41MTAxIDUuMzMzMzQgMTMuNjc5NyA1LjI2MzEgMTMuODA0NyA1LjEzODA3QzEzLjkyOTggNS4wMTMwNSAxNCA0Ljg0MzQ4IDE0IDQuNjY2NjdDMTQgNC40ODk4NiAxMy45Mjk4IDQuMzIwMjkgMTMuODA0NyA0LjE5NTI2QzEzLjY3OTcgNC4wNzAyNCAxMy41MTAxIDQgMTMuMzMzMyA0Wk02LjY2NjY3IDMuMzMzMzRDNi42NjY2NyAzLjE1NjUyIDYuNzM2OSAyLjk4Njk2IDYuODYxOTMgMi44NjE5M0M2Ljk4Njk1IDIuNzM2OTEgNy4xNTY1MiAyLjY2NjY3IDcuMzMzMzMgMi42NjY2N0g4LjY2NjY3QzguODQzNDggMi42NjY2NyA5LjAxMzA1IDIuNzM2OTEgOS4xMzgwNyAyLjg2MTkzQzkuMjYzMSAyLjk4Njk2IDkuMzMzMzMgMy4xNTY1MiA5LjMzMzMzIDMuMzMzMzRWNEg2LjY2NjY3VjMuMzMzMzRaTTExLjMzMzMgMTIuNjY2N0MxMS4zMzMzIDEyLjg0MzUgMTEuMjYzMSAxMy4wMTMxIDExLjEzODEgMTMuMTM4MUMxMS4wMTMgMTMuMjYzMSAxMC44NDM1IDEzLjMzMzMgMTAuNjY2NyAxMy4zMzMzSDUuMzMzMzNDNS4xNTY1MiAxMy4zMzMzIDQuOTg2OTUgMTMuMjYzMSA0Ljg2MTkzIDEzLjEzODFDNC43MzY5IDEzLjAxMzEgNC42NjY2NyAxMi44NDM1IDQuNjY2NjcgMTIuNjY2N1Y1LjMzMzM0SDExLjMzMzNWMTIuNjY2N1pNOS4zMzMzMyAxMkM5LjUxMDE0IDEyIDkuNjc5NzEgMTEuOTI5OCA5LjgwNDc0IDExLjgwNDdDOS45Mjk3NiAxMS42Nzk3IDEwIDExLjUxMDEgMTAgMTEuMzMzM1Y3LjMzMzM0QzEwIDcuMTU2NTMgOS45Mjk3NiA2Ljk4Njk2IDkuODA0NzQgNi44NjE5M0M5LjY3OTcxIDYuNzM2OTEgOS41MTAxNCA2LjY2NjY3IDkuMzMzMzMgNi42NjY2N0M5LjE1NjUyIDYuNjY2NjcgOC45ODY5NSA2LjczNjkxIDguODYxOTMgNi44NjE5M0M4LjczNjkxIDYuOTg2OTYgOC42NjY2NyA3LjE1NjUzIDguNjY2NjcgNy4zMzMzNFYxMS4zMzMzQzguNjY2NjcgMTEuNTEwMSA4LjczNjkxIDExLjY3OTcgOC44NjE5MyAxMS44MDQ3QzguOTg2OTUgMTEuOTI5OCA5LjE1NjUyIDEyIDkuMzMzMzMgMTJaXCIgZmlsbD1cIiNFMzRENUJcIi8+XG4gICAgICA8L3N2Zz5cbiAgICAgICR7aW5pdGlhbFRleHR9YDtcbiAgICB9XG4gICAgZGVsZXRlQnV0dG9ucy5mb3JFYWNoKChidXR0b24pID0+IGNoYW5nZURlbGV0ZUJ1dHRvbklubmVySHRtbChidXR0b24pKTtcbiAgICBjb25zdCBvYnNlcnZlciA9IG5ldyBNdXRhdGlvbk9ic2VydmVyKChtdXRhdGlvbnNMaXN0KSA9PiB7XG4gICAgICAgIG11dGF0aW9uc0xpc3QuZm9yRWFjaCgobXV0YXRpb24pID0+IHtcbiAgICAgICAgICAgIGlmIChtdXRhdGlvbi5hZGRlZE5vZGVzLmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgICAgICBtdXRhdGlvbi5hZGRlZE5vZGVzLmZvckVhY2goKG5vZGUpID0+IHtcbiAgICAgICAgICAgICAgICAgICAgaWYgKG5vZGUgaW5zdGFuY2VvZiBFbGVtZW50KSB7XG4gICAgICAgICAgICAgICAgICAgICAgICBpZiAobm9kZS5tYXRjaGVzKCcuZGVsZXRlLWl0ZW0tc2VsZWN0b3InKSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNoYW5nZURlbGV0ZUJ1dHRvbklubmVySHRtbChub2RlKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNvbnN0IG5ld0RlbGV0ZUJ1dHRvbnMgPSBub2RlLnF1ZXJ5U2VsZWN0b3JBbGwoJy5kZWxldGUtaXRlbS1zZWxlY3RvcicpO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIG5ld0RlbGV0ZUJ1dHRvbnMuZm9yRWFjaCgoYnV0dG9uKSA9PiBjaGFuZ2VEZWxldGVCdXR0b25Jbm5lckh0bWwoYnV0dG9uKSk7XG4gICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSk7XG4gICAgfSk7XG4gICAgb2JzZXJ2ZXIub2JzZXJ2ZShkb2N1bWVudC5ib2R5LCB7XG4gICAgICAgIGNoaWxkTGlzdDogdHJ1ZSxcbiAgICAgICAgc3VidHJlZTogdHJ1ZSxcbiAgICB9KTtcbiAgICAvKipcbiAgICAgKiBUaGlzIGZ1bmN0aW9uIGRvZXMgdHdvIG1haW4gdGhpbmdzOlxuICAgICAqXG4gICAgICogMS4gQWRkcyBhIGNsaWNrIGV2ZW50IGxpc3RlbmVyIHRvIHRoZSBidXR0b24gdG8gY29udHJvbCB0aGUgY29sbGFwc2libGUgZmxvdzpcbiAgICAgKiAgICAtIEl0IGZpbmRzIHRoZSBjbG9zZXN0IDxsYWJlbD4gZWxlbWVudCByZWxhdGVkIHRvIHRoZSBidXR0b24uXG4gICAgICogICAgLSBXaXRoaW4gdGhhdCA8bGFiZWw+LCBpdCBsb29rcyBmb3IgYW4gZWxlbWVudCB3aXRoIHRoZSBjbGFzcyAnb3B0aW9uYWwtdGV4dCcuIElmIGl0IGZpbmRzICdvcHRpb25hbC10ZXh0JywgaXQgdG9nZ2xlcyBob3cgdGhhdCB0ZXh0IGlzIGRpc3BsYXllZCAoZWl0aGVyIHdpdGggYnJhY2tldHMgb3IgYW4gaWNvbikuXG4gICAgICogICAgLSBJdCBhbHNvIGxvY2F0ZXMgdGhlIG5lYXJlc3QgcGFyZW50IGVsZW1lbnQgd2l0aCB0aGUgY2xhc3NlcyAnc3ViZWxlbWVudCByb3VuZGVkLXQtc20nLiBJZiB0aGF0IHBhcmVudCBzdWJlbGVtZW50IGV4aXN0cywgaXQgdG9nZ2xlcyBpdHMgc3RhdGUgdG8gZWl0aGVyIGNvbGxhcHNlIG9yIGV4cGFuZCB0aGUgZm9ybSBzZWN0aW9uLlxuICAgICAqICAgIC0gRmluYWxseSwgaXQgcm90YXRlcyB0aGUgY29sbGFwc2UgYnV0dG9uIGVhY2ggdGltZSBpdOKAmXMgY2xpY2tlZC5cbiAgICAgKlxuICAgICAqIDIuIEl0IHRyaWdnZXJzIHRoZSBidXR0b24gY2xpY2sgZXZlbnQgaWYgdGhlIHN1YmVsZW1lbnQgaXMgb3B0aW9uYWwgdXNpbmcgdGhlIGZsYWc6IHRoaXNCdXR0b25CZWxvbmdzVG9PcHRpb25hbEZvcm0uXG4gICAgICogICAgVGhpcyBlbnN1cmVzIG9wdGlvbmFsIGZvcm1zIHN0YXJ0IG9mZiBjb2xsYXBzZWQgYnkgZGVmYXVsdCB3aGVuIHJlbmRlcmVkLlxuICAgICAqXG4gICAgICogQHBhcmFtIGJ1dHRvbiAtIFRoZSBidXR0b24gZWxlbWVudCB0aGF0IG1hbmFnZXMgdGhlIGNvbGxhcHNpYmxlIGZvcm0gc2VjdGlvbi5cbiAgICAgKi9cbiAgICBmdW5jdGlvbiBhdHRhY2hDb2xsYXBzYWJsZUJ1dHRvbkV2ZW50cyhidXR0b24pIHtcbiAgICAgICAgY29uc3QgbGFiZWwgPSBnZXRDbG9zZXN0TGFiZWxEb20oYnV0dG9uKTtcbiAgICAgICAgY29uc3Qgb3B0aW9uYWxMYWJlbCA9IGxhYmVsID8gZ2V0T3B0aW9uYWxUZXh0RG9tKGxhYmVsKSA6IG51bGw7XG4gICAgICAgIGNvbnN0IHN1YmVsZW1lbnQgPSBsYWJlbCA/IGdldENsb3Nlc3RQYXJlbnRTdWJlbGVtZW50RG9tKGxhYmVsKSA6IG51bGw7XG4gICAgICAgIGNvbnN0IHRoaXNCdXR0b25CZWxvbmdzVG9PcHRpb25hbEZvcm0gPSBvcHRpb25hbExhYmVsICE9PSBudWxsO1xuICAgICAgICBidXR0b24uYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCAoKSA9PiB7XG4gICAgICAgICAgICBpZiAob3B0aW9uYWxMYWJlbCkge1xuICAgICAgICAgICAgICAgIHRvZ2dsZU9wdGlvbmFsVGV4dChvcHRpb25hbExhYmVsKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGlmIChzdWJlbGVtZW50KSB7XG4gICAgICAgICAgICAgICAgdG9nZ2xlQWNjb3JkaW9uSXRlbXMoc3ViZWxlbWVudCk7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBidXR0b24uY2xhc3NMaXN0LnRvZ2dsZSgncm90YXRlLTE4MCcpO1xuICAgICAgICB9KTtcbiAgICAgICAgaWYgKHRoaXNCdXR0b25CZWxvbmdzVG9PcHRpb25hbEZvcm0gJiYgIWVycm9yTWVzc2FnZUV4aXN0cyhzdWJlbGVtZW50KSkge1xuICAgICAgICAgICAgYnV0dG9uLmNsaWNrKCk7XG4gICAgICAgIH1cbiAgICB9XG4gICAgLyoqXG4gICAgICogQ2hlY2sgaWYgYW55IGVycm9yIG1lc3NhZ2UgZXhpc3RzIGluIHRoZSBzdWJlbGVtZW50LlxuICAgICAqXG4gICAgICogQHBhcmFtIHN1YmVsZW1lbnRcbiAgICAgKi9cbiAgICBmdW5jdGlvbiBlcnJvck1lc3NhZ2VFeGlzdHMoc3ViZWxlbWVudCkge1xuICAgICAgICBjb25zdCBlcnJvckRpdnMgPSBzdWJlbGVtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJy5lcnJvcicpO1xuICAgICAgICBjb25zdCBlcnJvclRleHRzID0gc3ViZWxlbWVudC5xdWVyeVNlbGVjdG9yQWxsKCcudGV4dC1kYW5nZXItZXJyb3InKTtcbiAgICAgICAgZm9yIChjb25zdCBkaXYgb2YgZXJyb3JEaXZzKSB7XG4gICAgICAgICAgICBpZiAoZGl2LnRleHRDb250ZW50LnRyaW0oKSAhPT0gJycpIHtcbiAgICAgICAgICAgICAgICByZXR1cm4gdHJ1ZTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfVxuICAgICAgICBmb3IgKGNvbnN0IGRpdiBvZiBlcnJvclRleHRzKSB7XG4gICAgICAgICAgICBpZiAoZGl2LnRleHRDb250ZW50LnRyaW0oKSAhPT0gJycpIHtcbiAgICAgICAgICAgICAgICByZXR1cm4gdHJ1ZTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfVxuICAgICAgICByZXR1cm4gZmFsc2U7XG4gICAgfVxuICAgIC8qKlxuICAgICAqIFJldHVybnMgY2xvc2VzdCA8bGFiZWw+IGVsZW1lbnQuXG4gICAgICpcbiAgICAgKiBAcGFyYW0gYnV0dG9uXG4gICAgICovXG4gICAgZnVuY3Rpb24gZ2V0Q2xvc2VzdExhYmVsRG9tKGJ1dHRvbikge1xuICAgICAgICByZXR1cm4gYnV0dG9uLmNsb3Nlc3QoJ2xhYmVsJyk7XG4gICAgfVxuICAgIC8qKlxuICAgICAqIFJldHVybnMgY2xvc2VzdCBlbGVtZW50IHdpdGggY2xhc3MgJ29wdGlvbmFsLXRleHQnLlxuICAgICAqXG4gICAgICogQHBhcmFtIGxhYmVsXG4gICAgICovXG4gICAgZnVuY3Rpb24gZ2V0T3B0aW9uYWxUZXh0RG9tKGxhYmVsKSB7XG4gICAgICAgIHJldHVybiBsYWJlbC5xdWVyeVNlbGVjdG9yKCcub3B0aW9uYWwtdGV4dCcpO1xuICAgIH1cbiAgICAvKipcbiAgICAgKiBSZXR1cm5zIHRoZSBmaXJzdCBOdGggcGFyZW50IHRoYXQgaGFzIGNsYXNzICdzdWJlbGVtZW50Jy5cbiAgICAgKlxuICAgICAqIEBwYXJhbSBsYWJlbFxuICAgICAqL1xuICAgIGZ1bmN0aW9uIGdldENsb3Nlc3RQYXJlbnRTdWJlbGVtZW50RG9tKGxhYmVsKSB7XG4gICAgICAgIHJldHVybiBsYWJlbC5jbG9zZXN0KCcuc3ViZWxlbWVudC5yb3VuZGVkLXQtc20nKTtcbiAgICB9XG4gICAgLyoqXG4gICAgICogVG9nZ2xlcyB3aGF0IGlzIHJlbmRlcmVkIG9uIG9wdGlvbmFsIHRleHQuIChkb3Qgb3IgYnJhY2tldClcbiAgICAgKlxuICAgICAqIEBwYXJhbSBvcHRpb25hbExhYmVsXG4gICAgICovXG4gICAgZnVuY3Rpb24gdG9nZ2xlT3B0aW9uYWxUZXh0KG9wdGlvbmFsTGFiZWwpIHtcbiAgICAgICAgY29uc3Qgb3B0aW9uYWxMYWJlbFdpdGhTdmcgPSAnPHN2ZyB2aWV3Qm94PVwiMCAwIDE2IDE4XCIgZmlsbD1cIm5vbmVcIiB4bWxucz1cImh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnXCI+PHBhdGggZD1cIk02IDlhMS44NyAxLjg3IDAgMSAwIDMuNzQgMEExLjg3IDEuODcgMCAwIDAgNiA5WlwiIGZpbGw9XCIjNjg3OTdFXCI+PC9wYXRoPjwvc3ZnPjxzcGFuPk9wdGlvbmFsPC9zcGFuPic7XG4gICAgICAgIGNvbnN0IG9wdGlvbmFsTGFiZWxXaXRoQnJhY2tldHMgPSAnPHNwYW4+KCBPcHRpb25hbCApPC9zcGFuPic7XG4gICAgICAgIGNvbnN0IHN2Z0V4aXN0cyA9IG9wdGlvbmFsTGFiZWwucXVlcnlTZWxlY3Rvcignc3ZnJykgIT09IG51bGw7XG4gICAgICAgIGlmIChzdmdFeGlzdHMpIHtcbiAgICAgICAgICAgIG9wdGlvbmFsTGFiZWwuaW5uZXJIVE1MID0gb3B0aW9uYWxMYWJlbFdpdGhCcmFja2V0cztcbiAgICAgICAgfVxuICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgIG9wdGlvbmFsTGFiZWwuaW5uZXJIVE1MID0gb3B0aW9uYWxMYWJlbFdpdGhTdmc7XG4gICAgICAgIH1cbiAgICB9XG4gICAgLyoqXG4gICAgICogVG9nZ2xlcyBjb2xsYXBzZWQgc3RhdGUuIChleHBhbmQgb3IgY29sbGFwc2VkKVxuICAgICAqXG4gICAgICogS2V5IGNvbnNpZGVyYXRpb25zOlxuICAgICAqIDEuIFRoZSBcIkFkZCBBZGRpdGlvbmFsXCIgYnV0dG9uIGNhbiBiZSBlaXRoZXIgaW5zaWRlIG9yIG91dHNpZGUgdGhlIHN1YmVsZW1lbnQuXG4gICAgICogMi4gV2hlbiB0aGUgYnV0dG9uIGlzIG91dHNpZGUsIGl0IHdpbGwgYWx3YXlzIGJlIHRoZSBpbW1lZGlhdGUgc2libGluZyB0byB0aGUgc3ViZWxlbWVudC5cbiAgICAgKiAzLiBUaGUgY29sbGFwc2UgbWVjaGFuaXNtIGlzIGhhbmRsZWQgYnkgYWRqdXN0aW5nIHRoZSBtYXggaGVpZ2h0IHRvIGdpdmUgdGhlIGlsbHVzaW9uIG9mIHNsaWRpbmcgdXAuXG4gICAgICogNC4gSWYgdGhlIGJ1dHRvbiBpcyBvdXRzaWRlIHRoZSBzdWJlbGVtZW50LCB0aGUgc2xpZGUtdXAgZWZmZWN0IHdpbGwgbm90IGFmZmVjdCB0aGUgYnV0dG9uLlxuICAgICAqICAgIFRoZXJlZm9yZSwgd2UgdG9nZ2xlIHRoZSAnZGlzcGxheS1ub25lJyBjbGFzcyB0byBjb250cm9sIGl0cyB2aXNpYmlsaXR5LlxuICAgICAqXG4gICAgICogQHBhcmFtIHN1YmVsZW1lbnRcbiAgICAgKi9cbiAgICBmdW5jdGlvbiB0b2dnbGVBY2NvcmRpb25JdGVtcyhzdWJlbGVtZW50KSB7XG4gICAgICAgIGZ1bmN0aW9uIGlzQWRkQWRkaXRpb25hbEJ1dHRvbk91dHNpZGUoc3ViZWxlbWVudCkge1xuICAgICAgICAgICAgY29uc3QgbmV4dFNpYmxpbmcgPSBzdWJlbGVtZW50Lm5leHRFbGVtZW50U2libGluZztcbiAgICAgICAgICAgIGlmIChuZXh0U2libGluZyAmJiBuZXh0U2libGluZy50YWdOYW1lID09PSAnQlVUVE9OJykge1xuICAgICAgICAgICAgICAgIHJldHVybiAobmV4dFNpYmxpbmcuY2xhc3NMaXN0LmNvbnRhaW5zKCdhZGRfbW9yZScpICYmXG4gICAgICAgICAgICAgICAgICAgIG5leHRTaWJsaW5nLmNsYXNzTGlzdC5jb250YWlucygnYnV0dG9uJykpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xuICAgICAgICB9XG4gICAgICAgIGNvbnN0IGhpZGVhYmxlU3ViZWxlbWVudHMgPSBbLi4uc3ViZWxlbWVudC5jaGlsZHJlbl0uZmlsdGVyKChjaGlsZCkgPT4gY2hpbGQudGFnTmFtZSAhPT0gJ0xBQkVMJyk7XG4gICAgICAgIGxldCBvdXRzaWRlQnV0dG9uID0gbnVsbDtcbiAgICAgICAgY29uc3QgaGFzQWRkQWRkaXRpb25hbEJ1dHRvbk91dHNpZGUgPSBpc0FkZEFkZGl0aW9uYWxCdXR0b25PdXRzaWRlKHN1YmVsZW1lbnQpO1xuICAgICAgICBpZiAoaGFzQWRkQWRkaXRpb25hbEJ1dHRvbk91dHNpZGUpIHtcbiAgICAgICAgICAgIG91dHNpZGVCdXR0b24gPSBzdWJlbGVtZW50Lm5leHRFbGVtZW50U2libGluZztcbiAgICAgICAgICAgIGlmIChvdXRzaWRlQnV0dG9uKSB7XG4gICAgICAgICAgICAgICAgb3V0c2lkZUJ1dHRvbi5jbGFzc0xpc3QudG9nZ2xlKCdkaXNwbGF5LW5vbmUnKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfVxuICAgICAgICBoaWRlYWJsZVN1YmVsZW1lbnRzLmZvckVhY2goKGNoaWxkKSA9PiB7XG4gICAgICAgICAgICBpZiAoaGFzQWRkQWRkaXRpb25hbEJ1dHRvbk91dHNpZGUgJiYgb3V0c2lkZUJ1dHRvbikge1xuICAgICAgICAgICAgICAgIHN1YmVsZW1lbnQuY2xhc3NMaXN0LnRvZ2dsZSgnbWItNicpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgaWYgKGNoaWxkLmNsYXNzTGlzdC5jb250YWlucygnaGVpZ2h0LWhpZGUnKSkge1xuICAgICAgICAgICAgICAgIGNoaWxkLmNsYXNzTGlzdC5yZW1vdmUoJ2hlaWdodC1oaWRlJyk7XG4gICAgICAgICAgICAgICAgY2hpbGQuY2xhc3NMaXN0LmFkZCgnaGVpZ2h0LXNob3cnKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgICAgIGNoaWxkLmNsYXNzTGlzdC5yZW1vdmUoJ2hlaWdodC1zaG93Jyk7XG4gICAgICAgICAgICAgICAgY2hpbGQuY2xhc3NMaXN0LmFkZCgnaGVpZ2h0LWhpZGUnKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSk7XG4gICAgfVxuICAgIC8qKlxuICAgICAqIFRoaXMgZnVuY3Rpb24gaGFuZGxlcyB0aGUgZm9ybXMgcmVuZGVyZWQgb24gaW5pdGlhbCBwYWdlIGxvYWQuXG4gICAgICovXG4gICAgZnVuY3Rpb24gYXR0YWNoSW5pdGlhbENvbGxhcHNhYmxlQnV0dG9uRXZlbnRzKCkge1xuICAgICAgICBjb25zdCBhbGxDb2xsYXBzYWJsZUJ1dHRvbnMgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuY29sbGFwc2FibGUtYnV0dG9uJyk7XG4gICAgICAgIGFsbENvbGxhcHNhYmxlQnV0dG9ucy5mb3JFYWNoKChidXR0b24pID0+IGF0dGFjaENvbGxhcHNhYmxlQnV0dG9uRXZlbnRzKGJ1dHRvbikpO1xuICAgIH1cbiAgICAvKipcbiAgICAgKiBUaGlzIGZ1bmN0aW9uIGhhbmRsZXMgdGhlIGZvcm1zIHJlbmRlcmVkIG9uIGNsaWNraW5nICdBREQgQURESVRJT05BTCBYJyBidXR0b24uXG4gICAgICovXG4gICAgZnVuY3Rpb24gb2JzZXJ2ZU5ld0NvbGxhcHNhYmxlQnV0dG9ucygpIHtcbiAgICAgICAgY29uc3Qgb2JzZXJ2ZXIgPSBuZXcgTXV0YXRpb25PYnNlcnZlcigobXV0YXRpb25zTGlzdCkgPT4ge1xuICAgICAgICAgICAgbXV0YXRpb25zTGlzdC5mb3JFYWNoKChtdXRhdGlvbikgPT4ge1xuICAgICAgICAgICAgICAgIGlmIChtdXRhdGlvbi50eXBlID09PSAnY2hpbGRMaXN0Jykge1xuICAgICAgICAgICAgICAgICAgICBtdXRhdGlvbi5hZGRlZE5vZGVzLmZvckVhY2goKG5vZGUpID0+IHtcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmIChub2RlIGluc3RhbmNlb2YgSFRNTEVsZW1lbnQpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBjb25zdCBuZXdDb2xsYXBzYWJsZUJ1dHRvbnMgPSBub2RlLnF1ZXJ5U2VsZWN0b3JBbGwoJy5jb2xsYXBzYWJsZS1idXR0b24nKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBuZXdDb2xsYXBzYWJsZUJ1dHRvbnMuZm9yRWFjaCgoYnV0dG9uKSA9PiBhdHRhY2hDb2xsYXBzYWJsZUJ1dHRvbkV2ZW50cyhidXR0b24pKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfSk7XG4gICAgICAgIH0pO1xuICAgICAgICBvYnNlcnZlci5vYnNlcnZlKGRvY3VtZW50LmJvZHksIHsgY2hpbGRMaXN0OiB0cnVlLCBzdWJ0cmVlOiB0cnVlIH0pO1xuICAgIH1cbiAgICBhdHRhY2hJbml0aWFsQ29sbGFwc2FibGVCdXR0b25FdmVudHMoKTtcbiAgICBvYnNlcnZlTmV3Q29sbGFwc2FibGVCdXR0b25zKCk7XG59KTtcbmZ1bmN0aW9uIGVzY2FwZUh0bWwodW5zYWZlKSB7XG4gICAgcmV0dXJuIHVuc2FmZVxuICAgICAgICAucmVwbGFjZSgvJi9nLCAnJmFtcDsnKVxuICAgICAgICAucmVwbGFjZSgvPC9nLCAnJmx0OycpXG4gICAgICAgIC5yZXBsYWNlKC8+L2csICcmZ3Q7JylcbiAgICAgICAgLnJlcGxhY2UoL1wiL2csICcmcXVvdDsnKVxuICAgICAgICAucmVwbGFjZSgvJy9nLCAnJiMwMzk7Jyk7XG59XG4vKlxuICpcbiAqIEhlbHAgVGV4dCBPcGVuIENsb3NlIEhhbmRsZXJzIFN0YXJ0XG4gKlxuICovXG4oMCwganF1ZXJ5XzEuZGVmYXVsdCkoZG9jdW1lbnQpLm9uKCdjbGljaycsIGZ1bmN0aW9uIChldmVudCkge1xuICAgIGlmICghKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGV2ZW50LnRhcmdldCkuY2xvc2VzdCgnLmhlbHAnKS5sZW5ndGgpIHtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuaGVscF9fdGV4dCcpLnJlbW92ZUF0dHIoJ3N0eWxlJyk7XG4gICAgfVxufSk7XG4oMCwganF1ZXJ5XzEuZGVmYXVsdCkoZG9jdW1lbnQpLm9uKCdjbGljaycsICcuaGVscCcsIGZ1bmN0aW9uIChldmVudCkge1xuICAgIGV2ZW50LnN0b3BQcm9wYWdhdGlvbigpO1xuICAgIGNvbnNvbGUubG9nKCdIZWxsbycpO1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLmhlbHBfX3RleHQnKS5yZW1vdmVBdHRyKCdzdHlsZScpO1xuICAgIGNvbnN0IGhlbHBUZXh0ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpLmZpbmQoJy5oZWxwX190ZXh0Jyk7XG4gICAgaWYgKGhlbHBUZXh0Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgaGVscFRleHQuY3NzKHtcbiAgICAgICAgICAgIG9wYWNpdHk6ICcxJyxcbiAgICAgICAgICAgIHZpc2liaWxpdHk6ICd2aXNpYmxlJyxcbiAgICAgICAgfSk7XG4gICAgfVxuICAgIGlmICgoMCwganF1ZXJ5XzEuZGVmYXVsdCkoZXZlbnQudGFyZ2V0KS5jbG9zZXN0KCcuY2xvc2UtaGVscCcpLmxlbmd0aCkge1xuICAgICAgICBjbG9zZUhlbHBUZXh0KGhlbHBUZXh0KTtcbiAgICB9XG59KTtcbigwLCBqcXVlcnlfMS5kZWZhdWx0KShkb2N1bWVudCkub24oJ2tleWRvd24nLCBmdW5jdGlvbiAoZXZlbnQpIHtcbiAgICBpZiAoZXZlbnQua2V5ID09PSAnRXNjYXBlJykge1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5oZWxwX190ZXh0JykuZWFjaChmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICBjbG9zZUhlbHBUZXh0KCgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKSk7XG4gICAgICAgIH0pO1xuICAgIH1cbn0pO1xuLyoqXG4gKiBDbG9zZXMgdGhlIGhlbHAgdGV4dCB0b29sdGlwIGJ5IHNldHRpbmcgaXRzIENTUyBwcm9wZXJ0aWVzIHRvIG1ha2UgaXQgaW52aXNpYmxlIGFuZCBub24taW50ZXJhY3RpdmUuXG4gKiBBZnRlciBhIGRlbGF5LCBpdCByZW1vdmVzIHRoZSBpbmxpbmUgc3R5bGVzIHRvIHJlc2V0IHRoZSBlbGVtZW50J3Mgc3RhdGUuXG4gKlxuICogQHBhcmFtIGhlbHBUZXh0IC0gVGhlIGpRdWVyeSBvYmplY3QgcmVwcmVzZW50aW5nIHRoZSB0b29sdGlwIGVsZW1lbnQgdG8gYmUgY2xvc2VkLlxuICovXG5mdW5jdGlvbiBjbG9zZUhlbHBUZXh0KGhlbHBUZXh0KSB7XG4gICAgaGVscFRleHQuY3NzKHtcbiAgICAgICAgJ3BvaW50ZXItZXZlbnRzJzogJ25vbmUnLFxuICAgICAgICBvcGFjaXR5OiAnMCcsXG4gICAgICAgIHZpc2liaWxpdHk6ICdpbnZpc2libGUnLFxuICAgIH0pO1xuICAgIHNldFRpbWVvdXQoZnVuY3Rpb24gKCkge1xuICAgICAgICBoZWxwVGV4dC5yZW1vdmVBdHRyKCdzdHlsZScpO1xuICAgIH0sIDEwMDApO1xufVxuLypcbiAqXG4gKiBIZWxwIFRleHQgT3BlbiBDbG9zZSBIYW5kbGVycyBFbmRcbiAqXG4gKi9cbiJdLCJuYW1lcyI6WyJfY2xhc3NDYWxsQ2hlY2siLCJpbnN0YW5jZSIsIkNvbnN0cnVjdG9yIiwiVHlwZUVycm9yIiwiX2RlZmluZVByb3BlcnRpZXMiLCJ0YXJnZXQiLCJwcm9wcyIsImkiLCJsZW5ndGgiLCJkZXNjcmlwdG9yIiwiZW51bWVyYWJsZSIsImNvbmZpZ3VyYWJsZSIsIndyaXRhYmxlIiwiT2JqZWN0IiwiZGVmaW5lUHJvcGVydHkiLCJrZXkiLCJfY3JlYXRlQ2xhc3MiLCJwcm90b1Byb3BzIiwic3RhdGljUHJvcHMiLCJwcm90b3R5cGUiLCJfX2ltcG9ydERlZmF1bHQiLCJtb2QiLCJfX2VzTW9kdWxlIiwiZXhwb3J0cyIsInZhbHVlIiwiRHluYW1pY0ZpZWxkIiwianF1ZXJ5XzEiLCJyZXF1aXJlIiwiaGlkZVNob3dGb3JtRmllbGRzIiwiaHVtYW5pdGFyaWFuU2NvcGVIaWRlVm9jYWJ1bGFyeVVyaSIsImNvdW50cnlCdWRnZXRIaWRlQ29kZUZpZWxkIiwiYWlkVHlwZVZvY2FidWxhcnlIaWRlRmllbGQiLCJzZWN0b3JWb2NhYnVsYXJ5SGlkZUZpZWxkIiwicG9saWN5Vm9jYWJ1bGFyeUhpZGVGaWVsZCIsInJlY2lwaWVudFZvY2FidWxhcnlIaWRlRmllbGQiLCJ0YWdWb2NhYnVsYXJ5SGlkZUZpZWxkIiwidHJhbnNhY3Rpb25BaWRUeXBlVm9jYWJ1bGFyeUhpZGVGaWVsZCIsImluZGljYXRvclJlZmVyZW5jZUhpZGVGaWVsZFVyaSIsIl90aGlzIiwiaHVtYW5pdGFyaWFuU2NvcGVWb2NhYnVsYXJ5IiwiZWFjaCIsImluZGV4Iiwic2NvcGUiLCJfYSIsInZhbCIsImhpZGVIdW1hbml0YXJpYW5TY29wZUZpZWxkIiwidG9TdHJpbmciLCJvbiIsImUiLCJwYXJhbXMiLCJkYXRhIiwiaWQiLCJjbG9zZXN0IiwiZmluZCIsInNob3ciLCJyZW1vdmVBdHRyIiwidHJpZ2dlciIsImhpZGUiLCJhdHRyIiwiX3RoaXMyIiwicmVmZXJlbmNlVm9jYWJ1bGFyeSIsImluZGljYXRvclJlZmVyZW5jZUhpZGVGaWVsZCIsInJlZmVyZW5jZVVyaSIsIl90aGlzMyIsImNvdW50cnlCdWRnZXRWb2NhYnVsYXJ5IiwiaGlkZUNvdW50cnlCdWRnZXRGaWVsZCIsImNvdW50cnlCdWRnZXRDb2RlSW5wdXQiLCJjb3VudHJ5QnVkZ2V0Q29kZVNlbGVjdCIsIl90aGlzNCIsImFpZHR5cGVfdm9jYWJ1bGFyeSIsIml0ZW0iLCJoaWRlQWlkVHlwZVNlbGVjdEZpZWxkIiwiX3RoaXM1IiwiaGlkZVRyYW5zYWN0aW9uQWlkVHlwZVNlbGVjdEZpZWxkIiwiZGVmYXVsdF9haWRfdHlwZSIsImVhcm1hcmtpbmdfY2F0ZWdvcnkiLCJlYXJtYXJraW5nX21vZGFsaXR5IiwiY2FzaF9hbmRfdm91Y2hlcl9tb2RhbGl0aWVzIiwiY2FzZTEiLCJjYXNlMiIsImNhc2UzIiwiY2FzZTQiLCJhaWRfdHlwZSIsIl90aGlzNiIsInBvbGljeW1ha2VyX3ZvY2FidWxhcnkiLCJwb2xpY3lfbWFya2VyIiwiaGlkZVBvbGljeU1ha2VyRmllbGQiLCJjYXNlMV9zaG93IiwiY2FzZTJfc2hvdyIsIl90aGlzNyIsInNlY3Rvcl92b2NhYnVsYXJ5Iiwic2VjdG9yIiwiaGlkZVNlY3RvckZpZWxkIiwiY2FzZTdfc2hvdyIsImNhc2U4X3Nob3ciLCJjYXNlOThfOTlfc2hvdyIsImRlZmF1bHRfc2hvdyIsImNhc2U3IiwiY2FzZTgiLCJjYXNlOThfOTkiLCJkZWZhdWx0X2hpZGUiLCJfdGhpczgiLCJyZWdpb25fdm9jYWJ1bGFyeSIsInJlZ2lvbl92b2NhYiIsImhpZGVSZWNpcGllbnRSZWdpb25GaWVsZCIsImNhc2U5OV9zaG93IiwiY2FzZTk5IiwidXBkYXRlQWN0aXZpdHlJZGVudGlmaWVyIiwiYWN0aXZpdHlfaWRlbnRpZmllciIsImNvbmNhdCIsIl90aGlzOSIsInRhZ192b2NhYnVsYXJ5IiwidGFnIiwiaGlkZVRhZ0ZpZWxkIiwiY2FzZTNfc2hvdyIsImRvY3VtZW50IiwiZXZlbnQiLCJzdG9wUHJvcGFnYXRpb24iLCJjb25zb2xlIiwibG9nIiwiaGVscFRleHQiLCJjc3MiLCJvcGFjaXR5IiwidmlzaWJpbGl0eSIsImNsb3NlSGVscFRleHQiLCJzZXRUaW1lb3V0IiwiX3RvQ29uc3VtYWJsZUFycmF5IiwiYXJyIiwiX2FycmF5V2l0aG91dEhvbGVzIiwiX2l0ZXJhYmxlVG9BcnJheSIsIl91bnN1cHBvcnRlZEl0ZXJhYmxlVG9BcnJheSIsIl9ub25JdGVyYWJsZVNwcmVhZCIsIml0ZXIiLCJTeW1ib2wiLCJpdGVyYXRvciIsIkFycmF5IiwiZnJvbSIsImlzQXJyYXkiLCJfYXJyYXlMaWtlVG9BcnJheSIsIl9jcmVhdGVGb3JPZkl0ZXJhdG9ySGVscGVyIiwibyIsImFsbG93QXJyYXlMaWtlIiwiaXQiLCJGIiwicyIsIm4iLCJkb25lIiwiX2UiLCJmIiwibm9ybWFsQ29tcGxldGlvbiIsImRpZEVyciIsImVyciIsImNhbGwiLCJzdGVwIiwibmV4dCIsIl9lMiIsIm1pbkxlbiIsInNsaWNlIiwiY29uc3RydWN0b3IiLCJuYW1lIiwidGVzdCIsImxlbiIsImFycjIiLCJheGlvc18xIiwiRHluYW1pY0ZpZWxkXzEiLCJkeW5hbWljRmllbGQiLCJGb3JtQnVpbGRlciIsImFkZEZvcm0iLCJldiIsInByZXZlbnREZWZhdWx0IiwiY29udGFpbmVyIiwiY291bnQiLCJwYXJzZUludCIsInBhcmVudCIsInBhcmVudF9jb3VudCIsInBhcmVudHMiLCJ3cmFwcGVyX3BhcmVudF9jb3VudCIsInByb3RvIiwicmVwbGFjZSIsInByZXYiLCJhcHBlbmQiLCJjaGlsZHJlbiIsImxhc3QiLCJzZWxlY3QyIiwicGxhY2Vob2xkZXIiLCJhbGxvd0NsZWFyIiwid3JhcEFsbCIsImFkZFBhcmVudEZvcm0iLCJhZGRXcmFwcGVyT25BZGQiLCJkZWxldGVGb3JtIiwiY29sbGVjdGlvbkxlbmd0aCIsInRnIiwicmVtb3ZlIiwiZGVsZXRlUGFyZW50Rm9ybSIsImFkZFdyYXBwZXIiLCJmb3JtRmllbGQiLCJ0ZXh0QXJlYUhlaWdodCIsImhlaWdodCIsInNjcm9sbEhlaWdodCIsImFkZFRvQ29sbGVjdGlvbiIsImhhc0NsYXNzIiwiaGFuZGxlRGVsZXRlUGFyZW50QnV0dG9ucyIsImRlbGV0ZUNvbGxlY3Rpb24iLCJkZWxldGVDb25maXJtYXRpb24iLCJjYW5jZWxQb3B1cCIsImRlbGV0ZUNvbmZpcm0iLCJkZWxldGVJbmRleCIsImNoaWxkT3JQYXJlbnQiLCJmYWRlSW4iLCJmYWRlT3V0IiwiZGVsZXRlQnV0dG9uIiwibXVsdGlGb3JtIiwiYmFja2dyb3VuZCIsIm91dGxpbmUiLCJmaWxlUGF0aCIsInVybCIsImdldCIsInRoZW4iLCJyZXNwb25zZSIsInN1Y2Nlc3MiLCJmb3JtYXQiLCJtaW1ldHlwZSIsIm1lc3NhZ2UiLCJmaWxlVXJsIiwiZGVsZXRlQnV0dG9ucyIsInF1ZXJ5U2VsZWN0b3JBbGwiLCJjaGFuZ2VEZWxldGVCdXR0b25Jbm5lckh0bWwiLCJidXR0b24iLCJpbml0aWFsVGV4dCIsImVzY2FwZUh0bWwiLCJ0ZXh0Q29udGVudCIsImlubmVySFRNTCIsImZvckVhY2giLCJmb3JtQnVpbGRlciIsInRleHRBcmVhVGFyZ2V0Iiwic2VsZWN0X3NlYXJjaCIsInF1ZXJ5U2VsZWN0b3IiLCJmb2N1cyIsInVwZGF0ZVJlZ2lzdHJhdGlvbkFnZW5jeSIsImNvdW50cnkiLCJlbmRwb2ludCIsImFqYXgiLCJjdXJyZW50X3ZhbCIsImVtcHR5IiwiT3B0aW9uIiwiaWRlbnRpZmllciIsInN1YmVsZW1lbnQiLCJ0aXRsZSIsImVycm9yQ29udGFpbmVyIiwiY2hpbGRDb3VudCIsImNoaWxkRWxlbWVudENvdW50IiwiY2xhc3NMaXN0IiwiYWRkIiwicmVhZE9ubHlTZWxlY3RzIiwic2VsZWN0Iiwic2VsZWN0RWxlbWVudFBhcmVudFdyYXBwZXIiLCJuZXh0U2libGluZyIsInNlbGVjdEVsZW1lbnRQYXJlbnQiLCJmaXJzdENoaWxkIiwic2VsZWN0RWxlbWVudCIsInN0eWxlIiwiY3Vyc29yIiwib2JzZXJ2ZXIiLCJNdXRhdGlvbk9ic2VydmVyIiwibXV0YXRpb25zTGlzdCIsIm11dGF0aW9uIiwiYWRkZWROb2RlcyIsIm5vZGUiLCJFbGVtZW50IiwibWF0Y2hlcyIsIm5ld0RlbGV0ZUJ1dHRvbnMiLCJvYnNlcnZlIiwiYm9keSIsImNoaWxkTGlzdCIsInN1YnRyZWUiLCJhdHRhY2hDb2xsYXBzYWJsZUJ1dHRvbkV2ZW50cyIsImxhYmVsIiwiZ2V0Q2xvc2VzdExhYmVsRG9tIiwib3B0aW9uYWxMYWJlbCIsImdldE9wdGlvbmFsVGV4dERvbSIsImdldENsb3Nlc3RQYXJlbnRTdWJlbGVtZW50RG9tIiwidGhpc0J1dHRvbkJlbG9uZ3NUb09wdGlvbmFsRm9ybSIsImFkZEV2ZW50TGlzdGVuZXIiLCJ0b2dnbGVPcHRpb25hbFRleHQiLCJ0b2dnbGVBY2NvcmRpb25JdGVtcyIsInRvZ2dsZSIsImVycm9yTWVzc2FnZUV4aXN0cyIsImNsaWNrIiwiZXJyb3JEaXZzIiwiZXJyb3JUZXh0cyIsIl9pdGVyYXRvciIsIl9zdGVwIiwiZGl2IiwidHJpbSIsIl9pdGVyYXRvcjIiLCJfc3RlcDIiLCJvcHRpb25hbExhYmVsV2l0aFN2ZyIsIm9wdGlvbmFsTGFiZWxXaXRoQnJhY2tldHMiLCJzdmdFeGlzdHMiLCJpc0FkZEFkZGl0aW9uYWxCdXR0b25PdXRzaWRlIiwibmV4dEVsZW1lbnRTaWJsaW5nIiwidGFnTmFtZSIsImNvbnRhaW5zIiwiaGlkZWFibGVTdWJlbGVtZW50cyIsImZpbHRlciIsImNoaWxkIiwib3V0c2lkZUJ1dHRvbiIsImhhc0FkZEFkZGl0aW9uYWxCdXR0b25PdXRzaWRlIiwiYXR0YWNoSW5pdGlhbENvbGxhcHNhYmxlQnV0dG9uRXZlbnRzIiwiYWxsQ29sbGFwc2FibGVCdXR0b25zIiwib2JzZXJ2ZU5ld0NvbGxhcHNhYmxlQnV0dG9ucyIsInR5cGUiLCJIVE1MRWxlbWVudCIsIm5ld0NvbGxhcHNhYmxlQnV0dG9ucyIsInVuc2FmZSJdLCJzb3VyY2VSb290IjoiIn0=
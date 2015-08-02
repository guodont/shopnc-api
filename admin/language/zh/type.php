<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * index
 */
$lang['type_index_related_fail']			= '部分信息添加失敗請重新編輯該類型。';
$lang['type_index_continue_to_dd']			= '繼續添加類型';
$lang['type_index_return_type_list']		= '返回類型列表';
$lang['type_index_del_succ']				= '類型刪除成功。';
$lang['type_index_del_fail']				= '類型刪除失敗。';
$lang['type_index_del_related_attr_fail']	= '刪除關聯屬性失敗。';
$lang['type_index_del_related_brand_fail']	= '刪除關聯品牌失敗。';
$lang['type_index_del_related_type_fail']	= '刪除關聯規格失敗。';
$lang['type_index_type_name']				= '類型';
$lang['type_index_no_checked']				= '請選擇要操作的數據項。';
$lang['type_index_prompts_one']				= '當管理員添加商品分類時需選擇類型。前台分類下商品列表頁通過類型生成商品檢索，方便用戶搜索需要的商品。';
/**
 * 新增屬性
 */
$lang['type_add_related_brand']				= '選擇關聯品牌';
$lang['type_add_related_spec']				= '選擇關聯規格';
$lang['type_add_remove']					= '移除';
$lang['type_add_name_no_null']				= '請填寫類型名稱';
$lang['type_add_name_max']					= '類型名稱長度應在1-10個字元之間';
$lang['type_add_sort_no_null']				= '請填寫類型排序';
$lang['type_add_sort_no_digits']			= '請填寫整數';
$lang['type_add_sort_desc']					= '請填寫自然數。類型列表將會根據排序進行由小到大排列顯示。';
$lang['type_add_spec_name']					= '規格名稱';
$lang['type_add_spec_value']				= '規格值';
$lang['type_add_spec_null_one']				= '還沒有規格，趕快去';
$lang['type_add_spec_null_two']				= '添加規格吧！';
$lang['type_add_brand_null_one']			= '還沒有品牌，趕快去';
$lang['type_add_brand_null_two']			= '添加品牌吧！';
$lang['type_add_attr_add']					= '添加屬性';
$lang['type_add_attr_add_one']				= '添加一個屬性';
$lang['type_add_attr_add_one_value']		= '添加一個屬性值';
$lang['type_add_attr_name']					= '屬性名稱';
$lang['type_add_attr_value']				= '屬性可選值';
$lang['type_add_prompts_one']				= '關聯規格不是必選項，它會影響商品發佈時的規格及價格的錄入。不選為沒有規格。';
$lang['type_add_prompts_two']				= '關聯品牌不是必選項，它會影響商品發佈時的品牌選擇。';
$lang['type_add_prompts_three']				= '屬性值可以添加多個，每個屬性值之間需要使用逗號隔開。';
$lang['type_add_prompts_four']				= '選中屬性的“顯示”選項，該屬性將會在商品列表頁顯示。';
$lang['type_add_spec_must_choose']			= '請至少選擇一種規格';
$lang['type_common_checked_hide']			= '隱藏未選項';
$lang['type_common_checked_show']			= '全部顯示';
$lang['type_common_belong_class']			= '所屬分類';
$lang['type_common_belong_class_tips']		= '選擇分類，可關聯大分類和更具體的下級分類。';
/**
 * 編輯屬性
 */
$lang['type_edit_type_value_null']			= '還沒有添加類型值信息。';
$lang['type_edit_type_value_del_fail']		= '類型值信息刪除失敗。';
$lang['type_edit_type_off_shelf']			= '商品是否下架';
$lang['type_edit_type_attr_edit']			= '編輯屬性';
$lang['type_edit_type_attr_is_show']		= '是否顯示';
$lang['type_edit_type_attr_name_no_null']	= '屬性值名稱不能為空';
$lang['type_edit_type_attr_name_max']		= '屬性值名稱不能超過10個字元';
$lang['type_edit_type_attr_sort_no_null']	= '排序不能為空';
$lang['type_edit_type_attr_sort_no_digits']	= '排序值只能為數字';
$lang['type_edit_type_attr_edit_succ']		= '屬性編輯成功';
$lang['type_edit_type_attr_edit_fail']		= '屬性編輯失敗';
$lang['type_attr_edit_name_desc']			= '請填寫常用的商品屬性的名稱；例如：材質；價格區間等';
$lang['type_attr_edit_sort_desc']			= ' 請填寫自然數。屬性列表將會根據排序進行由小到大排列顯示。';
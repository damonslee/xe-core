<?php
	require(_XE_PATH_ . 'test-phpUnit/config/config.inc.php');

	class MysqlUpdateTest extends MysqlTest {

                function _test($xml_file, $argsString, $expected, $columnList = null){
                    $this->_testQuery($xml_file, $argsString, $expected, 'getUpdateSql', $columnList);
		}

                function test_document_updateDocumentStatus(){
                        $xml_file = _XE_PATH_ . "modules/document/queries/updateDocumentStatus.xml";
			$argsString = '$args->is_secret = \'Y\';
                                       $args->status = \'SECRET\';
                        ';
                        $expected = 'update `xe_documents` as `documents` set `status` = \'secret\' where `is_secret` = \'y\'';
                        $this->_test($xml_file, $argsString, $expected);
                }

                /**
                 * Issue 388 - Query cache error related table alias
                 * http://code.google.com/p/xe-core/issues/detail?id=388
                 */
                function test_importer_updateDocumentSync(){
			$xml_file = _TEST_PATH_ . "db/xml_query/mysql/data/importer.updateDocumentSync.xml";
			$argsString = '';
			$expected = 'UPDATE `xe_documents` as `documents`, `xe_member` as `member`
                            SET `documents`.`member_srl` = `member`.`member_srl`
                            WHERE `documents`.`user_id` = `member`.`user_id`
                        ';
			$this->_test($xml_file, $argsString, $expected);
                }


	}
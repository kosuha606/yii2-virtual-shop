<?php

namespace app\virtualProviders\ZendLuceneSearch;

use Yii;
use yii\base\Component;
use yii\db\Exception;
use yii\log\Logger;
use ZendSearch\Lucene\Analysis\Analyzer\Analyzer;
use ZendSearch\Lucene\Analysis\Analyzer\Common\Text\CaseInsensitive;
use ZendSearch\Lucene\Analysis\Analyzer\Common\Utf8;
use ZendSearch\Lucene\Document;
use ZendSearch\Lucene\Document\Field;
use ZendSearch\Lucene\Index;
use ZendSearch\Lucene\Index\Term;
use ZendSearch\Lucene\Lucene;
use ZendSearch\Lucene\Search\Query\MultiTerm;
use ZendSearch\Lucene\Search\QueryParser;
use ZendSearch\Lucene\SearchIndexInterface;

/**
 * Class ZendSearchService
 * @package app\contexts\System\Search\services
 * @category Сервис
 */
class ZendSearchService
{
    /** @var mixed */
    private $indexPath;

    /**
     * @param mixed $indexPath
     */
    public function setIndexPath($indexPath)
    {
        $this->indexPath = $indexPath;
    }
    /**
     * @return bool|string
     */
    public function indexFile()
    {
        return Yii::getAlias($this->indexPath);
    }

    /**
     * @param $term
     * @return array
     */
    public function search($term)
    {
        Analyzer::setDefault(
            new CaseInsensitive()
        );
        QueryParser::setDefaultEncoding('UTF-8');
        $numDocs = null;
        $results = null;
        $query = null;
        try {
            $index = Lucene::open($this->indexFile());
            $numDocs = $index->numDocs();
            $hits = $index->find($term);
            foreach ($hits as $hit) {
                $results[] = $hit->getDocument();
            }
            $query = QueryParser::parse($term);
        } catch (\Exception $ex) {
            Yii::error($ex->getMessage());
        }
        return [
            'results' => $results,
            'query' => $query,
            'num_docs' => $numDocs,
        ];
    }

    /**
     * @return \ZendSearch\Lucene\SearchIndexInterface
     * @throws \yii\base\InvalidConfigException
     */
    public function getIndex()
    {
        $analyzer = new MyAnalizer();
        Analyzer::setDefault($analyzer);
        $index = Lucene::open($this->indexFile());
        return $index;
    }

    /**
     * @param $index
     */
    public function commitIndex(SearchIndexInterface $index)
    {
        $index->optimize();
        $index->commit();
    }

    public function removeFromIndex($modelId, $modelClass)
    {
        $query = new MultiTerm();
        $query->addTerm(new Term($modelId, 'model_id'), true);
        $query->addTerm(new Term($modelClass, 'model_class'), true);
        $index = $this->getIndex();
        $data = $index->find($query);

        foreach ($data as $hit) {
            $index->delete($hit->id);
        }

        $this->commitIndex($index);
    }

    public function clearIndex()
    {
        $index = Lucene::create($this->indexFile());
        $this->commitIndex($index);
    }

    /**
     * @param $indexData
     * @param SearchIndexInterface $index
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function indexArray($indexData)
    {
        $doc = new Document();

        foreach ($indexData as $indexDatum) {
            if (!isset($indexDatum['field'])) {
                throw new Exception('Field should be defined in zend search');
            }
            if (!isset($indexDatum['value'])) {
                throw new Exception('Value should be defined in zend search');
            }
            if (!isset($indexDatum['type'])) {
                throw new Exception('Type should be defined in zend search');
            }

            $doc->addField(Field::{$indexDatum['type']}($indexDatum['field'], $indexDatum['value'], 'UTF-8'));
        }

        $index = $this->getIndex();
        $index->addDocument($doc);
        $this->commitIndex($index);
    }

    /**
     * Create index
     * @throws Exception
     */
    public function reindex($indexData)
    {
        $analyzer = new MyAnalizer();
        Analyzer::setDefault($analyzer);
        $index = Lucene::create($this->indexFile());
        $this->clearIndex();

        foreach ($indexData as $indexDatum) {
            $this->indexArray($indexDatum, $index);
        }

        $index->optimize();
        $index->commit();
    }
}
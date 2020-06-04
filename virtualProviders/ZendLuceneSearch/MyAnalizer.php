<?php

namespace app\virtualProviders\ZendLuceneSearch;

use ZendSearch\Lucene\Analysis\Analyzer\Common\Text;
use ZendSearch\Lucene\Analysis\Token;

/**
 * Class MyAnalizer
 * @package app\contexts\System\Search\services
 * @category Анализатор поиск
 */
class MyAnalizer extends Text
{
    private $_position;

    private $_word_position = 3;

    /**
     * Установка позиции в начальное состояние
     */
    public function reset()
    {
        $this->_position = 0;
    }

    /**
     * API для разбиения на лексемы
     * Получение следующей лексемы
     * Возвращает null, если достигнут конец потока
     *
     * @return Token|null
     */
    public function nextToken()
    {
        if ($this->_input === null) {
            return null;
        }

        $words = explode(' ', $this->_input);

        while (count($words) > $this->_position) {
            $word = $words[$this->_position];
            $strlen = mb_strlen($word);
            $wordPosition = $this->_word_position;

            if ($strlen >= 3) {
                $tokenText = mb_substr($word, 0, $this->_word_position);
                $this->_word_position++;
                if ($tokenText === $word) {
                    $this->_position++;
                    $this->_word_position = 3;
                }

                $startPosition = 0;
                for ($i=0; $i<count($words);$i++) {
                    $wordLen = mb_strlen($words[$i]);
                    if ($i===$this->_position) {
                        break;
                    }
                    $startPosition += $wordLen;
                }
                $endPosition = $startPosition + $wordPosition;

                $token = new Token(
                    mb_strtolower($tokenText),
                    $startPosition,
                    $endPosition);
                $token = $this->normalize($token);
                if ($token !== null) {
                    return $token;
                }
            }
            $this->_position++;
            $this->_word_position = 3;
        }

        return null;
    }
}
<?php
/**
 * Copyright (c) 2017 DarkWeb Design
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

declare(strict_types=1);

namespace DarkWebDesign\SymfonyAddonTransformers;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Transforms between a boolean and a scalar value.
 *
 * @author Raymond Schouten
 *
 * @since 2.3
 */
class BooleanToValueTransformer implements DataTransformerInterface
{
    /** @var string */
    private $trueValue;

    /** @var string */
    private $falseValue;

    /**
     * Constructor.
     *
     * @param string|int|float|bool $trueValue
     * @param string|int|float|bool $falseValue
     */
    public function __construct($trueValue = true, $falseValue = false)
    {
        $this->trueValue = $trueValue;
        $this->falseValue = $falseValue;
    }

    /**
     * Transforms a value from the original representation to a transformed representation.
     *
     * @param bool|null $value
     *
     * @return string|int|float|bool|null
     *
     * @throws \Symfony\Component\Form\Exception\TransformationFailedException
     */
    public function transform($value)
    {
        if (null === $value) {
            return null;
        }

        if (!is_bool($value)) {
            throw new TransformationFailedException('Expected a boolean.');
        }

        return $value ? $this->trueValue : $this->falseValue;
    }

    /**
     * Transforms a value from the transformed representation to its original representation.
     *
     * @param string|int|float|bool|null $value
     *
     * @return bool|null
     *
     * @throws \Symfony\Component\Form\Exception\TransformationFailedException
     */
    public function reverseTransform($value): ?bool
    {
        if (null === $value || '' === $value) {
            return null;
        }

        if (!is_scalar($value)) {
            throw new TransformationFailedException('Expected a scalar.');
        }

        if (!($value === $this->trueValue || $value === $this->falseValue)) {
            throw new TransformationFailedException('Expected true/false boolean value.');
        }

        return $value === $this->trueValue;
    }
}

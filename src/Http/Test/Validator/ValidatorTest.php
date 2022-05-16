<?php

declare(strict_types=1);

namespace App\Http\Test\Validator;

use App\Http\Validator\ValidationException;
use App\Http\Validator\Validator;
use Exception;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Validation;
use Psr\Container\ContainerInterface;
use Symfony\Component\VarDumper\VarDumper;
use App\RequestUrl\Command\ReceiveUrl\Request\Command;
use Slim\App;

/**
 * @covers \App\Http\Validator\Validator
 *
 * @internal
 */
final class ValidatorTest extends TestCase
{
    private ?App $app = null;
    
//    public object $val;
//    
//    public function __construct(ValidatorInterface $val, $name = null, $data = [], $dataName = '') {
//        parent::__construct($name, $data, $dataName);
//        
//        $this->val = $val;
//    }
    protected function app(): App
    {
        if ($this->app === null) {
            $this->app = (require __DIR__ . '/../../../../config/app.php')($this->container());
        }
        return $this->app;
    }
    
    private function container(): ContainerInterface
    {
        /** @var ContainerInterface */
        return require __DIR__ . '/../../../../config/container.php';
    }
    
    public  function testValidation(): void
    {
        $container = $this->app()->getContainer();
        
        $val = $container->get(ValidatorInterface::class);
        
//        $origin = $this->createMock(ValidatorInterface::class);
//        
//        var_dump($origin);
//        var_dump($val); exit;
        $command = new stdClass();
        $command->url = "http://google.com";
        $origin = $this->createMock(ValidatorInterface::class);
        $origin->expects(self::once())->method('validate')
            ->with(self::equalTo($command->url))  
            ->willReturn(new ConstraintViolationList());
//        
//        VarDumper::dump($origin);
        
//        $validator = new Validator($val);
        $validator = new Validator($origin);
        
        $validator->validate($command);
        
//        VarDumper::dump($validator); //exit;
//        VarDumper::dump($valid); exit;
        
//        $constraint = $validator->validate($command);
        
//        VarDumper::dump($constraint); exit;
    }
    
    public function testValid(): void
    {
//        VarDumper::dump(ValidatorInterface::class); exit;
        $command = new stdClass();
        $command->url = "";
//        var_dump($command); exit;
        $origin = $this->createMock(ValidatorInterface::class);
//        $origin = $this->createMock(Validation::class);
//      VarDumper::dump($command); exit;
        
        $origin->expects(self::once())->method('validate')
            ->with(self::equalTo($command->url))
            ->willReturn(new ConstraintViolationList());
        
//        VarDumper::dump($origin); exit;

        $validator = new Validator($origin);
//                var_dump($origin);
//                var_dump($validator); exit;
        $validator->validate($command);
    }

    public function testNotValid(): void
    {
//        $validatory = $this->container->get(ValidatorInterface::class);
//        VarDumper::dump($valid); exit;
        
        $command = new stdClass();
        $command->url = "";

        $origin = $this->createMock(ValidatorInterface::class);
        $origin->expects(self::once())->method('validate')
            ->with(self::equalTo($command->url))
            ->willReturn($violations = new ConstraintViolationList([
                $this->createMock(ConstraintViolation::class),
            ]));

        $validator = new Validator($origin);

        try {
            $validator->validate($command);
            self::fail('Expected exception is not thrown');
        } catch (Exception $exception) {
            self::assertInstanceOf(ValidationException::class, $exception);
            self::assertEquals($violations, $exception->getViolations());
        }
    }
}

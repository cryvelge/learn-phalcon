# Phalcon 框架学习

namespace需要先注册才能使用
通过di set的服务使用$this->服务名->方法 可以调用
也可以通过
```
use Phalcon\Di;
Di::getDefault()->get('服务名')->方法名;
```
这种方式调用
### Metadata 元数据 就是 关于数据的数据
## 数据库事务
### 简单事务
```php
 $this->db->begin();
 $this->db->rollback();
 $this->db->commit();
```    
tips：当使用数据库关系进行存储相关记录时 会隐形的创建一个事务所以不用手动创建事务
### 单独事务
   单独事务在一个新的连接中执行所有的SQL，虚拟外键检查和业务规则与主数据库连接是相互独立的。 这种事务需要一个事务管理器来全局的管理每一个事务，保证他们在请求结束前能正确的回滚或者提交。 
```php
use Phalcon\Mvc\Model\Transaction\Failed as TxFailed
use Phalcon\Mvc\Model\Transaction\Manager as TxManager
    
try {
    //创建一个事务管理器
    $manager = new TxManager();
    
    //请求一个事务
    $transaction = $manager->get();
    $robot = new Robots();
    $robot->setTransaction($transaction);
    $robot->name = "WALLE";
    if($robot->save() == false) {
        $transaction->rollback("Can't save Robot");
    }
    $transaction->commit();
} catch(TxFailed $e) {
    echo "Falied, reason:" . $e->getMessage();
}
```
##验证数据完整性

# Phalcon 框架学习

namespace需要先注册才能使用
通过di set的服务使用$this->服务名->方法 可以调用
也可以通过
```
use Phalcon\Di;
Di::getDefault()->get('服务名')->方法名;
```
这种方式调用    
// webpack/createJsonVariables.js

const fs = require('fs');

// Функция для парсинга SCSS файла
function parseScss(filePath) {
  const data = fs.readFileSync(filePath, 'utf8');
  const lines = data.split('\n');
  const jsonObject = {};
  let currentBlockName = null;
  let isObject = false;
  let currentObject = {};

  lines.forEach(line => {
    line = line.trim();

    // Обработка начала блока
    if (line.startsWith('// scss-start')) {
      const blockInfo = line.replace('// scss-start ', '').split('-');
      currentBlockName = blockInfo.slice(0, -1).join('-');
      isObject = blockInfo[blockInfo.length - 1] === 'object';
      currentObject = isObject ? {} : {};
    }

    // Обработка конца блока
    if (line.startsWith('// scss-end')) {
      jsonObject[currentBlockName] = currentObject;
      currentBlockName = null;
      currentObject = {};
      isObject = false;
    }

    // Обработка переменных и объектов
    if (currentBlockName && !line.startsWith('//')) {
      if (isObject) {
        const [key, value] = line.split(':').map(item => item.trim());
        if (key && value && !/^[()]+$/.test(value)) {
          currentObject[key.replace(/[$"]/g, '')] = value.replace(/[,;]/g, '');
        }
      } else {
        const [key, value] = line.split(':').map(item => item.trim());
        if (key && value) {
          currentObject[key.replace('$', '')] = value.replace(';', '');
        }
      }
    }
  });

  return jsonObject;
}

// Запись результата в файл
function writeJson(filePath, jsonObject) {
  const jsonContent = JSON.stringify(jsonObject, null, 2);
  fs.writeFileSync(filePath, jsonContent, 'utf8');
}

// Основная функция
function createJsonVariables(customScssPath, customJsonPath) {
  const jsonObject = parseScss(customScssPath);
  writeJson(customJsonPath, jsonObject);

  console.log('Парсинг завершен. Результат записан в variables.json');
}

module.exports = createJsonVariables;

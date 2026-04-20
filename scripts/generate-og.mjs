import fs from 'node:fs/promises';
import path from 'node:path';
import { createCanvas } from '@napi-rs/canvas';

const [, , payloadPath] = process.argv;

if (!payloadPath) {
  console.error('Usage: node scripts/generate-og.mjs <payload-path>');
  process.exit(1);
}

const payload = JSON.parse(await fs.readFile(payloadPath, 'utf8'));

const canvas = createCanvas(1200, 630);
const ctx = canvas.getContext('2d');

ctx.textBaseline = 'alphabetic';
ctx.fillStyle = '#ff6a1c';
ctx.fillRect(0, 0, 1200, 630);

const background = ctx.createLinearGradient(0, 0, 1200, 630);
background.addColorStop(0, '#ff6a1c');
background.addColorStop(0.5, '#ff7d34');
background.addColorStop(1, '#ff9b4b');
ctx.fillStyle = background;
ctx.fillRect(0, 0, 1200, 630);

drawSoftCircle(ctx, 980, 96, 210, 'rgba(255,255,255,0.16)');
drawSoftCircle(ctx, 1090, 540, 150, 'rgba(255,255,255,0.12)');
drawSoftCircle(ctx, 160, 120, 130, 'rgba(255,255,255,0.10)');

ctx.fillStyle = 'rgba(15, 23, 42, 0.18)';
ctx.fillRect(0, 0, 1200, 630);

ctx.fillStyle = 'rgba(255, 255, 255, 0.14)';
for (let index = 0; index < 8; index += 1) {
  ctx.fillRect(760 + index * 48, 0, 10, 630);
}

ctx.fillStyle = '#ffffff';
ctx.font = '800 24px Segoe UI, Aptos, sans-serif';
ctx.fillText(payload.siteName, 72, 84);

ctx.fillStyle = 'rgba(255, 255, 255, 0.82)';
ctx.font = '600 16px Segoe UI, Aptos, sans-serif';
ctx.fillText(payload.siteTagline, 72, 114);

drawPill(ctx, payload.type, 948, 62);

drawBadge(ctx, 'Open Graph Preview', 72, 178);

ctx.fillStyle = '#ffffff';
ctx.font = '900 76px Segoe UI, Aptos, sans-serif';
drawWrappedText(ctx, payload.title, 72, 252, 760, 78, 3);

ctx.fillStyle = 'rgba(255, 255, 255, 0.82)';
ctx.font = '500 28px Segoe UI, Aptos, sans-serif';
drawWrappedText(ctx, payload.subtitle, 72, 444, 700, 42, 3);

drawPanel(ctx, payload.siteName, payload.siteTagline);

await fs.mkdir(path.dirname(payload.outputPath), { recursive: true });
await fs.writeFile(payload.outputPath, canvas.toBuffer('image/jpeg', { quality: 0.92 }));

function drawSoftCircle(context, centerX, centerY, radius, color) {
  context.beginPath();
  context.fillStyle = color;
  context.arc(centerX, centerY, radius, 0, Math.PI * 2);
  context.fill();
}

function drawBadge(context, text, x, y) {
  context.save();
  context.fillStyle = 'rgba(255,255,255,0.17)';
  roundedRect(context, x, y, 240, 46, 23);
  context.fill();
  context.fillStyle = '#ffffff';
  context.font = '700 13px Segoe UI, Aptos, sans-serif';
  context.fillText(text.toUpperCase(), x + 18, y + 29);
  context.restore();
}

function drawPill(context, text, x, y) {
  context.save();
  context.fillStyle = 'rgba(15, 23, 42, 0.20)';
  roundedRect(context, x, y, 180, 46, 23);
  context.fill();
  context.fillStyle = '#ffffff';
  context.beginPath();
  context.arc(x + 22, y + 23, 5, 0, Math.PI * 2);
  context.fill();
  context.font = '700 14px Segoe UI, Aptos, sans-serif';
  context.fillText(String(text).toUpperCase(), x + 40, y + 28);
  context.restore();
}

function drawPanel(context, siteName, siteTagline) {
  const x = 836;
  const y = 352;
  const width = 292;
  const height = 206;

  context.save();
  context.fillStyle = 'rgba(15, 23, 42, 0.62)';
  roundedRect(context, x, y, width, height, 28);
  context.fill();
  context.strokeStyle = 'rgba(255,255,255,0.14)';
  context.lineWidth = 1;
  context.stroke();

  context.fillStyle = 'rgba(255,255,255,0.72)';
  context.font = '700 13px Segoe UI, Aptos, sans-serif';
  context.fillText('Preview Card', x + 24, y + 36);

  context.fillStyle = '#ffffff';
  context.font = '600 20px Segoe UI, Aptos, sans-serif';
  drawWrappedText(context, 'Clean composition, strong contrast, and a branded orange field for social sharing.', x + 24, y + 78, 244, 28, 4);

  context.fillStyle = 'rgba(255,255,255,0.80)';
  context.font = '700 14px Segoe UI, Aptos, sans-serif';
  context.fillText('1200 x 630', x + 24, y + 162);
  context.font = '500 12px Segoe UI, Aptos, sans-serif';
  context.fillText('Standard social preview', x + 24, y + 182);

  context.textAlign = 'right';
  context.fillStyle = '#ffffff';
  context.font = '700 16px Segoe UI, Aptos, sans-serif';
  context.fillText(siteName, x + width - 24, y + 162);
  context.fillStyle = 'rgba(255,255,255,0.80)';
  context.font = '500 12px Segoe UI, Aptos, sans-serif';
  context.fillText(siteTagline, x + width - 24, y + 182);
  context.restore();
}

function drawWrappedText(context, text, x, y, maxWidth, lineHeight, maxLines) {
  const words = String(text || '').trim().split(/\s+/).filter(Boolean);
  const lines = [];
  let currentLine = '';

  for (const word of words) {
    const candidate = currentLine ? `${currentLine} ${word}` : word;

    if (context.measureText(candidate).width <= maxWidth) {
      currentLine = candidate;
      continue;
    }

    if (currentLine) {
      lines.push(currentLine);
    }

    currentLine = word;

    if (lines.length === maxLines - 1) {
      break;
    }
  }

  if (currentLine) {
    lines.push(currentLine);
  }

  const outputLines = lines.slice(0, maxLines);
  outputLines.forEach((line, index) => {
    context.fillText(line, x, y + (index * lineHeight));
  });
}

function roundedRect(context, x, y, width, height, radius) {
  const normalizedRadius = Math.min(radius, width / 2, height / 2);

  context.beginPath();
  context.moveTo(x + normalizedRadius, y);
  context.arcTo(x + width, y, x + width, y + height, normalizedRadius);
  context.arcTo(x + width, y + height, x, y + height, normalizedRadius);
  context.arcTo(x, y + height, x, y, normalizedRadius);
  context.arcTo(x, y, x + width, y, normalizedRadius);
  context.closePath();
}